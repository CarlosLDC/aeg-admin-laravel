<?php

use App\Enums\VenezuelaState;
use App\Filament\Resources\Companies\Resources\Branches\Pages\CreateBranch;
use App\Models\Company;
use App\Models\User;
use App\Services\AI\DocumentExtractionService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\mock;

uses(LazilyRefreshDatabase::class);

it('fills the branch form from an extracted document', function () {
    /** @var User $user */
    $user = User::factory()->createOne();
    $company = Company::factory()->createOne();

    actingAs($user);

    $disk = (string) config('ai.disk', 'local');
    Storage::fake($disk);

    $documentPath = 'ai/branch-documents/branch.pdf';
    Storage::disk($disk)->put($documentPath, '%PDF-1.4 fake branch document');

    mock(DocumentExtractionService::class, function ($mock) use ($documentPath, $disk): void {
        $mock->shouldReceive('extractBranchDataFromDocument')
            ->once()
            ->with($documentPath, $disk)
            ->andReturn([
                'trade_name' => 'Sucursal Caracas',
                'state' => 'distrito_capital',
                'city' => 'Caracas',
                'address' => 'Av. Principal, edificio, piso y referencia',
                'phone_primary' => '0212-555-0000',
                'phone_secondary' => '0212-555-0001',
                'email' => 'contacto@empresa.com',
                'contact_person' => 'Nombre y apellido',
            ]);
    });

    Livewire::test(CreateBranch::class, [
        'parentRecord' => $company,
    ])
        ->callAction('autofillFromDocument', data: [
            'document' => [$documentPath],
        ])
        ->assertSchemaStateSet([
            'trade_name' => 'Sucursal Caracas',
            'state' => VenezuelaState::DistritoCapital,
            'city' => 'Caracas',
            'address' => 'Av. Principal, edificio, piso y referencia',
            'phone_primary' => '0212-555-0000',
            'phone_secondary' => '0212-555-0001',
            'email' => 'contacto@empresa.com',
            'contact_person' => 'Nombre y apellido',
        ]);
});

it('normalizes branch phone fields to digits and plus signs only', function () {
    Storage::fake('local');

    $documentPath = 'ai/branch-documents/branch.png';
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
                            'trade_name' => 'Sucursal Caracas',
                            'state' => 'distrito_capital',
                            'city' => 'Caracas',
                            'address' => 'Av. Principal',
                            'phone_primary' => '+58 (212) 555-0000',
                            'phone_secondary' => '0212-555-0001 ext. 3',
                            'email' => 'contacto@empresa.com',
                            'contact_person' => 'Nombre y apellido',
                        ], JSON_THROW_ON_ERROR),
                    ]],
                ],
            ]],
        ]),
    ]);

    $payload = app(DocumentExtractionService::class)->extractBranchDataFromDocument($documentPath, 'local');

    expect($payload)->toBe([
        'trade_name' => 'Sucursal Caracas',
        'state' => 'distrito_capital',
        'city' => 'Caracas',
        'address' => 'Av. Principal',
        'phone_primary' => '+582125550000',
        'phone_secondary' => '021255500013',
        'email' => 'contacto@empresa.com',
        'contact_person' => 'Nombre y apellido',
    ]);
});
