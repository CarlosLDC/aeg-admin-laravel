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
