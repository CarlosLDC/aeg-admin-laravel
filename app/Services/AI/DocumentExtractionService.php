<?php

namespace App\Services\AI;

use App\Enums\TaxpayerType;
use App\Enums\VenezuelaState;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class DocumentExtractionService
{
    /**
     * @return array{tax_id?: string, legal_name?: string, taxpayer_type?: string}
     */
    public function extractCompanyDataFromDocument(string $path, ?string $disk = null): array
    {
        return $this->extractDocumentData($path, $disk, 'company');
    }

    /**
     * @return array{trade_name?: string, state?: string, city?: string, address?: string, phone_primary?: string, phone_secondary?: string, email?: string, contact_person?: string}
     */
    public function extractBranchDataFromDocument(string $path, ?string $disk = null): array
    {
        return $this->extractDocumentData($path, $disk, 'branch');
    }

    /**
     * @return array<string, string>
     */
    private function extractDocumentData(string $path, ?string $disk, string $documentType): array
    {
        $disk ??= (string) config('ai.disk', 'local');

        $absolutePath = Storage::disk($disk)->path($path);

        if (! is_file($absolutePath)) {
            throw new RuntimeException('No se encontró el documento cargado para procesarlo.');
        }

        $apiKey = (string) config('ai.api_key');

        if ($apiKey === '') {
            throw new RuntimeException('No se configuró la API key de Gemini.');
        }

        $endpoint = $this->buildEndpoint();

        try {
            $response = Http::acceptJson()
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->timeout((int) config('ai.timeout', 90))
                ->retry(2, 250)
                ->post($endpoint, $this->buildRequestBody($path, $disk, $documentType));
        } catch (ConnectionException $exception) {
            throw new RuntimeException('No fue posible conectar con el servicio de extracción.', previous: $exception);
        }

        if (! $response->successful()) {
            throw new RuntimeException('La IA no pudo procesar el documento: '.$response->body());
        }

        return match ($documentType) {
            'company' => $this->normalizeCompanyPayload($this->resolvePayload($response->json())),
            'branch' => $this->normalizeBranchPayload($this->resolvePayload($response->json())),
            default => throw new RuntimeException('Tipo de documento no soportado para extracción.'),
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function resolvePayload(mixed $response): array
    {
        if (! is_array($response)) {
            throw new RuntimeException('La respuesta de la IA no tiene un formato válido.');
        }

        $candidateText = Arr::get($response, 'candidates.0.content.parts.0.text');

        if (is_string($candidateText)) {
            $decoded = json_decode($candidateText, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        $candidateParts = Arr::get($response, 'candidates.0.content.parts', []);

        if (is_array($candidateParts)) {
            $mergedText = collect($candidateParts)
                ->pluck('text')
                ->filter(static fn (mixed $value): bool => is_string($value) && $value !== '')
                ->implode('');

            if ($mergedText !== '') {
                $decoded = json_decode($mergedText, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }

                throw new RuntimeException('La IA respondió texto que no pudo convertirse a JSON.');
            }
        }

        $candidate = $response['text'] ?? null;

        if (is_string($candidate)) {
            $decoded = json_decode($candidate, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            throw new RuntimeException('La IA respondió texto que no pudo convertirse a JSON.');
        }

        throw new RuntimeException('La IA respondió un formato inesperado.');
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array{tax_id?: string, legal_name?: string, taxpayer_type?: string}
     */
    private function normalizeCompanyPayload(array $payload): array
    {
        $data = Arr::only($payload, ['tax_id', 'legal_name', 'taxpayer_type']);

        $taxId = $this->normalizeTaxId($data['tax_id'] ?? null);
        $legalName = $this->normalizeLegalName($data['legal_name'] ?? null);
        $taxpayerType = $this->normalizeTaxpayerType($data['taxpayer_type'] ?? null);

        $normalized = array_filter([
            'tax_id' => $taxId,
            'legal_name' => $legalName,
            'taxpayer_type' => $taxpayerType,
        ], static fn (mixed $value): bool => filled($value));

        if ($normalized === []) {
            throw new RuntimeException('La IA no devolvió datos útiles para completar la empresa.');
        }

        return $normalized;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array{trade_name?: string, state?: string, city?: string, address?: string, phone_primary?: string, phone_secondary?: string, email?: string, contact_person?: string}
     */
    private function normalizeBranchPayload(array $payload): array
    {
        $data = Arr::only($payload, [
            'trade_name',
            'state',
            'city',
            'address',
            'phone_primary',
            'phone_secondary',
            'email',
            'contact_person',
        ]);

        $tradeName = $this->normalizeText($data['trade_name'] ?? null);
        $state = $this->normalizeState($data['state'] ?? null);
        $city = $this->normalizeText($data['city'] ?? null);
        $address = $this->normalizeText($data['address'] ?? null);
        $phonePrimary = $this->normalizePhone($data['phone_primary'] ?? null);
        $phoneSecondary = $this->normalizePhone($data['phone_secondary'] ?? null);
        $email = $this->normalizeEmail($data['email'] ?? null);
        $contactPerson = $this->normalizeText($data['contact_person'] ?? null);

        $normalized = array_filter([
            'trade_name' => $tradeName,
            'state' => $state,
            'city' => $city,
            'address' => $address,
            'phone_primary' => $phonePrimary,
            'phone_secondary' => $phoneSecondary,
            'email' => $email,
            'contact_person' => $contactPerson,
        ], static fn (mixed $value): bool => filled($value));

        if ($normalized === []) {
            throw new RuntimeException('La IA no devolvió datos útiles para completar la sucursal.');
        }

        return $normalized;
    }

    private function normalizeTaxId(mixed $taxId): ?string
    {
        if (! is_string($taxId)) {
            return null;
        }

        $normalized = strtoupper(Str::of($taxId)->replaceMatches('/[^A-Za-z0-9]/', '')->toString());

        if ($normalized === '') {
            return null;
        }

        if (! preg_match('/^[VEJGCP][0-9]{1,9}$/', $normalized)) {
            throw new RuntimeException('El RIF extraído no tiene un formato válido.');
        }

        return $normalized;
    }

    private function normalizeLegalName(mixed $legalName): ?string
    {
        return $this->normalizeText($legalName);
    }

    private function normalizeText(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $normalized = trim(preg_replace('/\s+/', ' ', $value) ?? '');

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeEmail(mixed $email): ?string
    {
        if (! is_string($email)) {
            return null;
        }

        $normalized = strtolower(trim($email));

        if ($normalized === '' || filter_var($normalized, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return $normalized;
    }

    private function normalizePhone(mixed $phone): ?string
    {
        if (! is_string($phone)) {
            return null;
        }

        $normalized = Str::of($phone)
            ->replaceMatches('/[^0-9+]/', '')
            ->toString();

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeState(mixed $state): ?string
    {
        if (! is_string($state)) {
            return null;
        }

        $candidate = Str::of($state)
            ->trim()
            ->lower()
            ->ascii()
            ->replace(['á', 'é', 'í', 'ó', 'ú', 'ü'], ['a', 'e', 'i', 'o', 'u', 'u'])
            ->replaceMatches('/[^a-z0-9]+/', '_')
            ->trim('_')
            ->toString();

        if ($candidate === '') {
            return null;
        }

        $enum = VenezuelaState::tryFrom($candidate);

        if ($enum === null) {
            throw new RuntimeException('El estado extraído no es válido.');
        }

        return $enum->value;
    }

    private function normalizeTaxpayerType(mixed $taxpayerType): ?string
    {
        if (! is_string($taxpayerType)) {
            return null;
        }

        $normalized = strtolower(trim($taxpayerType));

        if ($normalized === '') {
            return null;
        }

        $enum = TaxpayerType::tryFrom($normalized);

        if ($enum === null) {
            throw new RuntimeException('El tipo de contribuyente extraído no es válido.');
        }

        return $enum->value;
    }

    private function buildPrompt(): string
    {
        return <<<'PROMPT'
Eres un motor de extracción de documentos para formularios de empresas en Venezuela.

Lee el PDF cargado y devuelve exclusivamente JSON válido, sin markdown, sin explicaciones y sin texto adicional.

Debes extraer solo estos campos:
- tax_id: RIF normalizado, solo una letra inicial de V, E, J, G, C o P seguida de dígitos, sin guiones ni espacios.
- legal_name: razón social exacta y limpia.
- taxpayer_type: uno de ordinario, especial o formal.

Reglas:
- Si un campo no puede determinarse con confianza razonable, omítelo.
- No inventes valores.
- No incluyas claves adicionales.
- Si encuentras variantes visuales del RIF, normalízalas al formato esperado.

Respuesta esperada:
{
  "tax_id": "J123456789",
  "legal_name": "Alpha Engineer Group, C.A.",
  "taxpayer_type": "ordinario"
}
PROMPT;
    }

    private function buildEndpoint(): string
    {
        $baseUrl = rtrim((string) config('ai.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $model = trim((string) config('ai.model', 'gemini-3-flash-preview'));

        if ($baseUrl === '') {
            throw new RuntimeException('No se configuró la URL base de Gemini.');
        }

        if ($model === '') {
            throw new RuntimeException('No se configuró el modelo de Gemini.');
        }

        return $baseUrl.'/models/'.rawurlencode($model).':generateContent';
    }

    /**
     * @return array<string, mixed>
     */
    private function buildRequestBody(string $path, string $disk, string $documentType): array
    {
        return [
            'systemInstruction' => [
                'parts' => [
                    [
                        'text' => $documentType === 'branch'
                            ? 'Responde estrictamente en JSON válido con solo las claves de la sucursal solicitadas.'
                            : 'Responde estrictamente en JSON válido con solo las claves solicitadas.',
                    ],
                ],
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => $documentType === 'branch'
                                ? $this->buildBranchPrompt()
                                : $this->buildPrompt(),
                        ],
                        $this->buildDocumentPart($path, $disk),
                    ],
                ],
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'responseJsonSchema' => $documentType === 'branch'
                    ? $this->buildBranchResponseSchema()
                    : $this->buildResponseSchema(),
                'thinkingConfig' => [
                    'thinkingLevel' => 'HIGH',
                ],
            ],
        ];
    }

    private function buildBranchPrompt(): string
    {
        return <<<'PROMPT'
Eres un motor de extracción de documentos para formularios de sucursales en Venezuela.

Lee el documento cargado y devuelve exclusivamente JSON válido, sin markdown, sin explicaciones y sin texto adicional.

Debes extraer solo estos campos:
- trade_name: nombre comercial de la sucursal.
- state: estado venezolano normalizado en minúsculas y con guion bajo, por ejemplo distrito_capital o la_guaira.
- city: ciudad.
- address: dirección completa.
- phone_primary: teléfono principal.
- phone_secondary: teléfono secundario, si existe.
- email: correo electrónico.
- contact_person: persona de contacto.

Reglas:
- Si un campo no puede determinarse con confianza razonable, omítelo.
- No inventes valores.
- No incluyas claves adicionales.

Respuesta esperada:
{
  "trade_name": "Sucursal Caracas",
  "state": "distrito_capital",
  "city": "Caracas",
  "address": "Av. Principal, edificio, piso y referencia",
  "phone_primary": "0212-555-0000",
  "phone_secondary": "0212-555-0001",
  "email": "contacto@empresa.com",
  "contact_person": "Nombre y apellido"
}
PROMPT;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildBranchResponseSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'trade_name' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'state' => [
                    'anyOf' => [
                        [
                            'type' => 'string',
                            'enum' => array_values(array_map(static fn (VenezuelaState $state): string => $state->value, VenezuelaState::cases())),
                        ],
                        ['type' => 'null'],
                    ],
                ],
                'city' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'address' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'phone_primary' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'phone_secondary' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'email' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
                'contact_person' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                ],
            ],
            'required' => ['trade_name', 'state', 'city', 'address', 'phone_primary', 'phone_secondary', 'email', 'contact_person'],
            'additionalProperties' => false,
            'propertyOrdering' => ['trade_name', 'state', 'city', 'address', 'phone_primary', 'phone_secondary', 'email', 'contact_person'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildDocumentPart(string $path, string $disk): array
    {
        $mimeType = Storage::disk($disk)->mimeType($path) ?: 'application/octet-stream';

        if (! Str::startsWith($mimeType, ['image/', 'application/pdf'])) {
            throw new RuntimeException('Formato de archivo no soportado para Gemini.');
        }

        $contents = Storage::disk($disk)->get($path);

        if ($contents === '') {
            throw new RuntimeException('No se pudo leer el documento cargado.');
        }

        return [
            'inlineData' => [
                'mimeType' => $mimeType,
                'data' => base64_encode($contents),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildResponseSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'tax_id' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                    'description' => 'RIF normalizado, con una letra inicial seguida de dígitos.',
                ],
                'legal_name' => [
                    'anyOf' => [
                        ['type' => 'string'],
                        ['type' => 'null'],
                    ],
                    'description' => 'Razón social exacta y limpia.',
                ],
                'taxpayer_type' => [
                    'anyOf' => [
                        [
                            'type' => 'string',
                            'enum' => ['ordinario', 'especial', 'formal'],
                        ],
                        ['type' => 'null'],
                    ],
                    'description' => 'Tipo de contribuyente detectado.',
                ],
            ],
            'required' => ['tax_id', 'legal_name', 'taxpayer_type'],
            'additionalProperties' => false,
            'propertyOrdering' => ['tax_id', 'legal_name', 'taxpayer_type'],
        ];
    }
}
