<?php

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use App\Filament\Resources\Precints\Pages\CreatePrecint;
use App\Filament\Resources\Precints\Pages\EditPrecint;
use App\Filament\Resources\Precints\Pages\ListPrecints;
use App\Filament\Resources\Precints\Pages\ViewPrecint;
use App\Models\Precint;
use App\Models\Printer;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('can load the precints resource pages', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $precint = Precint::factory()->create();

    Livewire::test(ListPrecints::class)->assertOk();
    Livewire::test(CreatePrecint::class)->assertOk();
    Livewire::test(EditPrecint::class, ['record' => $precint->id])->assertOk();
    Livewire::test(ViewPrecint::class, ['record' => $precint->id])->assertOk();
});

it('can create a precint', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printer = Printer::factory()->create();

    Livewire::test(CreatePrecint::class)
        ->fillForm([
            'printer_id' => $printer->id,
            'serial' => 'AB12CD34EF',
            'color' => ColorPrecint::Rojo->value,
            'estatus' => EstatusPrecint::Disponible->value,
            'fecha_instalacion' => now()->toDateTimeString(),
            'fecha_retiro' => null,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Precint::class, [
        'serial' => 'AB12CD34EF',
        'printer_id' => $printer->id,
        'color' => ColorPrecint::Rojo->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);
});

it('can create precints in batch from the list page', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    Livewire::test(ListPrecints::class)
        ->callAction('bulkCreate', data: [
            'color' => ColorPrecint::Azul->value,
            'prefix' => 'abc',
            'start_number' => 1,
            'end_number' => 3,
        ]);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000001',
        'color' => ColorPrecint::Azul->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000002',
        'color' => ColorPrecint::Azul->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000003',
        'color' => ColorPrecint::Azul->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);
});

it('creates available precints in batch and skips duplicated serials', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    Precint::factory()->create([
        'serial' => 'ABC0000002',
    ]);

    Livewire::test(ListPrecints::class)
        ->callAction('bulkCreate', data: [
            'color' => ColorPrecint::Verde->value,
            'prefix' => 'ABC',
            'start_number' => 1,
            'end_number' => 3,
        ]);

    expect(Precint::query()->count())->toBe(3);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000001',
        'color' => ColorPrecint::Verde->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000002',
    ]);

    assertDatabaseHas(Precint::class, [
        'serial' => 'ABC0000003',
        'color' => ColorPrecint::Verde->value,
        'estatus' => EstatusPrecint::Disponible->value,
    ]);
});
