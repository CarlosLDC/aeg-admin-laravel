<?php

use App\Enums\DeviceType;
use App\Enums\PrinterStatus;
use App\Filament\Resources\Printers\Pages\CreatePrinter;
use App\Filament\Resources\Printers\Pages\EditPrinter;
use App\Filament\Resources\Printers\Pages\ListPrinters;
use App\Models\Branch;
use App\Models\Distributor;
use App\Models\Firmware;
use App\Models\Precint;
use App\Models\Printer;
use App\Models\PrinterModel;
use App\Models\Sale;
use App\Models\Software;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('can load the printers resource pages', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printer = Printer::factory()->create();

    Livewire::test(ListPrinters::class)->assertOk();
    Livewire::test(CreatePrinter::class)->assertOk();
    Livewire::test(EditPrinter::class, ['record' => $printer->id])->assertOk();
});

it('can create an printer', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printerModel = PrinterModel::factory()->create();
    $software = Software::factory()->create();
    $sale = Sale::factory()->create();
    $branch = Branch::factory()->create();
    $firmware = Firmware::factory()->create();
    $distributor = Distributor::factory()->create();

    Livewire::test(CreatePrinter::class)
        ->fillForm([
            'id_modelo_printer' => $printerModel->id,
            'id_software' => $software->id,
            'id_venta' => $sale->id,
            'id_sucursal' => $branch->id,
            'serial_fiscal' => 'ABC1234567',
            'precio_venta_final' => 1500,
            'estatus' => PrinterStatus::Installed->value,
            'id_firmware' => $firmware->id,
            'id_distribuidora' => $distributor->id,
            'se_pago' => true,
            'fecha_instalacion' => now()->toDateTimeString(),
            'direccion_mac' => 'AA:BB:CC:DD:EE:FF',
            'tipo_dispositivo' => DeviceType::External->value,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Printer::class, [
        'serial_fiscal' => 'ABC1234567',
        'id_modelo_printer' => $printerModel->id,
        'estatus' => PrinterStatus::Installed->value,
        'tipo_dispositivo' => DeviceType::External->value,
    ]);
});

it('blocks deleting an printer when it has attached precints', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printer = Printer::factory()->create();
    Precint::factory()->for($printer, 'printer')->create();

    Livewire::test(EditPrinter::class, [
        'record' => $printer->id,
    ])
        ->callAction(DeleteAction::class)
        ->assertNotified('No se puede eliminar este registro porque tiene información relacionada.')
        ->assertNoRedirect();

    assertDatabaseHas(Printer::class, [
        'id' => $printer->id,
    ]);
});
