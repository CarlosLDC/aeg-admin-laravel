<?php

use App\Enums\ColorPrecinto;
use App\Enums\EstatusPrecinto;
use App\Filament\Resources\Precintos\Pages\CreatePrecinto;
use App\Filament\Resources\Precintos\Pages\EditPrecinto;
use App\Filament\Resources\Precintos\Pages\ListPrecintos;
use App\Filament\Resources\Precintos\Pages\ViewPrecinto;
use App\Models\Impresora;
use App\Models\Precinto;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('can load the precintos resource pages', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $precinto = Precinto::factory()->create();

    Livewire::test(ListPrecintos::class)->assertOk();
    Livewire::test(CreatePrecinto::class)->assertOk();
    Livewire::test(EditPrecinto::class, ['record' => $precinto->id])->assertOk();
    Livewire::test(ViewPrecinto::class, ['record' => $precinto->id])->assertOk();
});

it('can create a precinto', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $impresora = Impresora::factory()->create();

    Livewire::test(CreatePrecinto::class)
        ->fillForm([
            'id_impresora' => $impresora->id,
            'serial' => 'AB12CD34EF',
            'color' => ColorPrecinto::Rojo->value,
            'estatus' => EstatusPrecinto::Disponible->value,
            'fecha_instalacion' => now()->toDateTimeString(),
            'fecha_retiro' => null,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Precinto::class, [
        'serial' => 'AB12CD34EF',
        'id_impresora' => $impresora->id,
        'color' => ColorPrecinto::Rojo->value,
        'estatus' => EstatusPrecinto::Disponible->value,
    ]);
});
