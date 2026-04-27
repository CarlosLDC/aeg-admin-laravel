<?php

use App\Enums\PrinterStatus;
use App\Filament\Resources\Printers\Pages\CreatePrinter;
use App\Filament\Resources\Printers\Pages\EditPrinter;
use App\Filament\Resources\Printers\Pages\ListPrinters;
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

it('adds lightweight visual guidance to the printer form', function () {
    $contents = file_get_contents(base_path('app/Filament/Schemas/PrinterSchemas.php'));

    expect($contents)
        ->toContain('Datos para reconocer la impresora de forma rápida.')
        ->toContain('Estado operativo y relación con el cliente actual.')
        ->toContain('Opcional, para relacionar la impresora con su venta.')
        ->toContain('Datos técnicos opcionales para firmware y software.')
        ->toContain('Grid::make(2)')
        ->toContain("->placeholder('Selecciona un modelo')")
        ->toContain("->placeholder('Sin asignar')")
        ->toContain("->placeholder('FAC-0000001')")
        ->toContain("->placeholder('Selecciona una versión')");
});

it('can create an printer', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printerModel = PrinterModel::factory()->create();
    $software = Software::factory()->create();
    $sale = Sale::factory()->create();
    $firmware = Firmware::factory()->create();
    Distributor::factory()->create();

    Livewire::test(CreatePrinter::class)
        ->fillForm([
            'printer_model_id' => $printerModel->id,
            'software_id' => $software->id,
            'sale_id' => $sale->id,
            'fiscal_serial_number' => 'ABC1234567',
            'final_sale_price' => 1500,
            'status' => PrinterStatus::Installed->value,
            'firmware_id' => $firmware->id,
            'is_paid' => true,
            'installation_date' => now()->toDateString(),
            'mac_address' => 'AA:BB:CC:DD:EE:FF',
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC1234567',
        'printer_model_id' => $printerModel->id,
        'status' => PrinterStatus::Installed->value,
    ]);
});

it('can create printers in batch from the list page', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $printerModel = PrinterModel::factory()->create();

    Livewire::test(ListPrinters::class)
        ->callAction('bulkCreate', data: [
            'printer_model_id' => $printerModel->id,
            'prefix' => 'abc',
            'start_number' => 1,
            'end_number' => 3,
        ]);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000001',
        'printer_model_id' => $printerModel->id,
        'status' => PrinterStatus::Testing->value,
        'is_paid' => false,
    ]);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000002',
        'printer_model_id' => $printerModel->id,
        'status' => PrinterStatus::Testing->value,
        'is_paid' => false,
    ]);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000003',
        'printer_model_id' => $printerModel->id,
        'status' => PrinterStatus::Testing->value,
        'is_paid' => false,
    ]);
});

it('creates available printers in batch and skips duplicated serials', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $existingPrinter = Printer::factory()->create([
        'fiscal_serial_number' => 'ABC0000002',
    ]);

    Livewire::test(ListPrinters::class)
        ->callAction('bulkCreate', data: [
            'printer_model_id' => $existingPrinter->printer_model_id,
            'prefix' => 'ABC',
            'start_number' => 1,
            'end_number' => 3,
        ]);

    expect(Printer::query()->count())->toBe(3);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000001',
    ]);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000002',
    ]);

    assertDatabaseHas(Printer::class, [
        'fiscal_serial_number' => 'ABC0000003',
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
