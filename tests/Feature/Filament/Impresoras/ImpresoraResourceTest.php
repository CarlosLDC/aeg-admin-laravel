<?php

use App\Enums\DeviceType;
use App\Enums\ImpresoraStatus;
use App\Filament\Resources\Impresoras\Pages\CreateImpresora;
use App\Filament\Resources\Impresoras\Pages\EditImpresora;
use App\Filament\Resources\Impresoras\Pages\ListImpresoras;
use App\Models\Branch;
use App\Models\Distributor;
use App\Models\Firmware;
use App\Models\Impresora;
use App\Models\Precinto;
use App\Models\PrinterModel;
use App\Models\Purchase;
use App\Models\Software;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('can load the impresoras resource pages', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $impresora = Impresora::factory()->create();

    Livewire::test(ListImpresoras::class)->assertOk();
    Livewire::test(CreateImpresora::class)->assertOk();
    Livewire::test(EditImpresora::class, ['record' => $impresora->id])->assertOk();
});

it('can create an impresora', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printerModel = PrinterModel::factory()->create();
    $software = Software::factory()->create();
    $purchase = Purchase::factory()->create();
    $branch = Branch::factory()->create();
    $firmware = Firmware::factory()->create();
    $distributor = Distributor::factory()->create();

    Livewire::test(CreateImpresora::class)
        ->fillForm([
            'id_modelo_impresora' => $printerModel->id,
            'id_software' => $software->id,
            'id_compra' => $purchase->id,
            'id_sucursal' => $branch->id,
            'serial_fiscal' => 'ABC1234567',
            'precio_venta_final' => 1500,
            'estatus' => ImpresoraStatus::Instalada->value,
            'id_firmware' => $firmware->id,
            'id_distribuidora' => $distributor->id,
            'se_pago' => true,
            'fecha_instalacion' => now()->toDateTimeString(),
            'version_firmware' => '1.0.0',
            'direccion_mac' => 'AA:BB:CC:DD:EE:FF',
            'tipo_dispositivo' => DeviceType::Externo->value,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Impresora::class, [
        'serial_fiscal' => 'ABC1234567',
        'id_modelo_impresora' => $printerModel->id,
        'estatus' => ImpresoraStatus::Instalada->value,
        'tipo_dispositivo' => DeviceType::Externo->value,
    ]);
});

it('blocks deleting an impresora when it has attached precintos', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $impresora = Impresora::factory()->create();
    Precinto::factory()->for($impresora, 'impresora')->create();

    Livewire::test(EditImpresora::class, [
        'record' => $impresora->id,
    ])
        ->callAction(DeleteAction::class)
        ->assertNotified('No se puede eliminar este registro porque tiene información relacionada.')
        ->assertNoRedirect();

    assertDatabaseHas(Impresora::class, [
        'id' => $impresora->id,
    ]);
});
