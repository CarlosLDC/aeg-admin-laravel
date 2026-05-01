<?php

use App\Enums\TaxpayerType;
use App\Enums\VenezuelaState;
use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Models\User;
use App\Services\AI\DocumentExtractionService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\mock;

uses(LazilyRefreshDatabase::class);

it('fills the branch form from an extracted document', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

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
                'tax_id' => 'J123456789',
                'legal_name' => 'Alpha Engineer Group, C.A.',
                'taxpayer_type' => 'ordinario',
                'trade_name' => 'Sucursal Caracas',
                'state' => 'distrito_capital',
                'city' => 'Caracas',
                'address' => 'Av. Principal, edificio, piso y referencia',
                'phone_primary' => '+5802125550000',
                'phone_secondary' => '+5802125550001',
                'email' => 'contacto@empresa.com',
                'contact_person' => 'Nombre y apellido',
            ]);
    });

    Livewire::test(CreateBranch::class)
        ->callAction('autofillFromDocument', data: [
            'document' => [$documentPath],
        ])
        ->assertSchemaStateSet([
            'tax_id' => 'J123456789',
            'legal_name' => 'Alpha Engineer Group, C.A.',
            'taxpayer_type' => TaxpayerType::Ordinary,
            'trade_name' => 'Sucursal Caracas',
            'state' => VenezuelaState::DistritoCapital,
            'city' => 'Caracas',
            'address' => 'Av. Principal, edificio, piso y referencia',
            'phone_primary' => '+5802125550000',
            'phone_secondary' => '+5802125550001',
            'email' => 'contacto@empresa.com',
            'contact_person' => 'Nombre y apellido',
        ]);
});
