<?php

use App\Enums\BranchRoles;
use App\Enums\TaxpayerType;
use App\Enums\VenezuelaState;
use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Filament\Resources\Branches\Pages\EditBranch;
use App\Models\Branch;
use App\Models\User;
use App\Services\Branches\BranchRoleService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(LazilyRefreshDatabase::class);

it('persists selected branch roles when creating a branch', function () {
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
            'roles' => [BranchRoles::Distributor, BranchRoles::Client],
        ])
        ->call('create')
        ->assertNotified();

    $branch = Branch::query()
        ->where('trade_name', 'Sucursal Caracas')
        ->firstOrFail();

    expect(app(BranchRoleService::class)->selectedRoles($branch))->toEqualCanonicalizing([
        BranchRoles::Distributor,
        BranchRoles::Client,
    ]);

    expect($branch->roles)->toEqualCanonicalizing([
        BranchRoles::Distributor->value,
        BranchRoles::Client->value,
    ]);

    expect($branch->distributor()->exists())->toBeTrue();
    expect($branch->client()->exists())->toBeTrue();
    expect($branch->serviceCenter()->exists())->toBeFalse();
    expect($branch->softwareProvider()->exists())->toBeFalse();
});

it('syncs selected branch roles when editing a branch', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $branch = Branch::factory()->create([
        'trade_name' => 'Sucursal Valencia',
    ]);

    $branch->distributor()->create([]);
    $branch->serviceCenter()->create([]);

    Livewire::test(EditBranch::class, [
        'record' => $branch->id,
    ])
        ->fillForm([
            'roles' => [BranchRoles::Distributor, BranchRoles::Client],
        ])
        ->call('save')
        ->assertNotified();

    $branch->refresh();

    expect(app(BranchRoleService::class)->selectedRoles($branch))->toEqualCanonicalizing([
        BranchRoles::Distributor,
        BranchRoles::Client,
    ]);

    expect($branch->roles)->toEqualCanonicalizing([
        BranchRoles::Distributor->value,
        BranchRoles::Client->value,
    ]);

    expect($branch->distributor()->exists())->toBeTrue();
    expect($branch->client()->exists())->toBeTrue();
    expect($branch->serviceCenter()->exists())->toBeFalse();
    expect($branch->softwareProvider()->exists())->toBeFalse();
});
