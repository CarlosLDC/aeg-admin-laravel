<?php

use App\Enums\BranchRoles;
use App\Enums\TaxpayerType;
use App\Enums\VenezuelaState;
use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Models\Branch;
use App\Models\User;
use App\Services\Branches\BranchRoleService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(LazilyRefreshDatabase::class);

it('persists selected branch roles when creating a company branch', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    Livewire::test(CreateBranch::class)
        ->fillForm([
            'tax_id' => 'J123456789',
            'legal_name' => 'Alpha Engineer Group, C.A.',
            'taxpayer_type' => TaxpayerType::Ordinary,
            'trade_name' => 'Sucursal Caracas',
            'state' => VenezuelaState::DistritoCapital,
            'city' => 'Caracas',
            'address' => 'Av. Principal',
            'phone_primary' => '+5802125550000',
            'phone_secondary' => '+5802125550001',
            'email' => 'contacto@empresa.com',
            'contact_person' => 'Nombre y apellido',
            'roles' => [BranchRoles::ServiceCenter, BranchRoles::SoftwareProvider],
        ])
        ->call('create')
        ->assertNotified();

    $branch = Branch::query()
        ->where('trade_name', 'Sucursal Caracas')
        ->firstOrFail();

    expect(app(BranchRoleService::class)->selectedRoles($branch))->toEqualCanonicalizing([
        BranchRoles::ServiceCenter,
        BranchRoles::SoftwareProvider,
    ]);

    expect($branch->serviceCenter()->exists())->toBeTrue();
    expect($branch->softwareProvider()->exists())->toBeTrue();
    expect($branch->distributor()->exists())->toBeFalse();
    expect($branch->client()->exists())->toBeFalse();
});
