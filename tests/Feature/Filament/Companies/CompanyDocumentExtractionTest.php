<?php

use App\Services\AI\DocumentExtractionService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

it('normalizes the payload returned by the ai endpoint', function () {
    Storage::fake('local');

    $documentPath = 'ai/company-documents/company.png';
    Storage::disk('local')->put($documentPath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/w8AAgMBgL5xJmQAAAAASUVORK5CYII='));

    config()->set('ai.base_url', 'https://generativelanguage.googleapis.com/v1beta');
    config()->set('ai.api_key', 'secret-token');
    config()->set('ai.model', 'gemini-3-flash-preview');
    config()->set('ai.timeout', 5);

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [[
                'content' => [
                    'parts' => [[
                        'text' => json_encode([
                            'tax_id' => 'j-12345678-9',
                            'legal_name' => '  Alpha   Engineer Group, C.A.  ',
                            'taxpayer_type' => 'ordinario',
                        ], JSON_THROW_ON_ERROR),
                    ]],
                ],
            ]],
        ]),
    ]);

    $payload = app(DocumentExtractionService::class)->extractCompanyDataFromDocument($documentPath, 'local');

    expect($payload)->toBe([
        'tax_id' => 'J123456789',
        'legal_name' => 'Alpha Engineer Group, C.A.',
        'taxpayer_type' => 'ordinario',
    ]);

    Http::assertSent(function ($request): bool {
        $payload = $request->data();

        $parts = $payload['contents'][0]['parts'] ?? [];
        $hasImage = collect($parts)
            ->contains(static fn (array $item): bool => isset($item['inlineData']));

        return $request->hasHeader('x-goog-api-key', 'secret-token')
            && ($payload['generationConfig']['responseMimeType'] ?? null) === 'application/json'
            && $hasImage;
    });
});
