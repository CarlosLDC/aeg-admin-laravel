<?php

use App\Filament\Resources\Sales\Pages\CreateSale;
use App\Filament\Resources\Sales\Pages\EditSale;
use App\Filament\Resources\Sales\Pages\ListSales;
use App\Models\Distributor;
use App\Models\Printer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('can load the sales resource pages', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $sale = Sale::factory()->create();

    Livewire::test(ListSales::class)->assertOk();
    Livewire::test(CreateSale::class)->assertOk();
    Livewire::test(EditSale::class, ['record' => $sale->id])->assertOk();
});

it('shows the sales form sections with visual hierarchy', function () {
    $saleForm = file_get_contents(base_path('app/Filament/Resources/Sales/Schemas/SaleForm.php'));

    expect($saleForm)
        ->toContain('Información de Venta')
        ->toContain('Resumen de Totales')
        ->toContain('->disabled()');
});

it('orders invoice number and date before distributor across sales surfaces', function () {
    $saleForm = file_get_contents(base_path('app/Filament/Resources/Sales/Schemas/SaleForm.php'));
    $saleInfolist = file_get_contents(base_path('app/Filament/Resources/Sales/Schemas/SaleInfolist.php'));
    $salesTable = file_get_contents(base_path('app/Filament/Resources/Sales/Tables/SalesTable.php'));

    expect(strpos($saleForm, "TextInput::make('invoice_number')"))->toBeLessThan(strpos($saleForm, "DatePicker::make('sale_date')"));
    expect(strpos($saleForm, "DatePicker::make('sale_date')"))->toBeLessThan(strpos($saleForm, "Select::make('distributor_id')"));

    expect(strpos($saleInfolist, "TextEntry::make('invoice_number')"))->toBeLessThan(strpos($saleInfolist, "TextEntry::make('sale_date')"));
    expect(strpos($saleInfolist, "TextEntry::make('sale_date')"))->toBeLessThan(strpos($saleInfolist, "TextEntry::make('distributor.branch.trade_name')"));

    expect(strpos($salesTable, "TextColumn::make('invoice_number')"))->toBeLessThan(strpos($salesTable, "TextColumn::make('sale_date')"));
    expect(strpos($salesTable, "TextColumn::make('sale_date')"))->toBeLessThan(strpos($salesTable, "TextColumn::make('distributor.branch.trade_name')"));
});

it('allows inactive taxes to be selected in sales forms', function () {
    $saleItemForm = file_get_contents(base_path('app/Filament/Resources/Sales/Resources/SaleItems/Schemas/SaleItemForm.php'));
    $printerSchemas = file_get_contents(base_path('app/Filament/Schemas/PrinterSchemas.php'));

    expect($saleItemForm)->toContain('modifyQueryUsing: fn (Builder $query): Builder => $query')
        ->and($saleItemForm)->toContain('(Inactiva)')
        ->and($printerSchemas)->toContain('modifyQueryUsing: fn (Builder $query): Builder => $query')
        ->and($printerSchemas)->toContain('(Inactiva)');
});

it('can create a sale and assign printers from sale items relation', function () {
    /** @var User $user */
    $user = User::factory()->createOne();

    actingAs($user);

    $distributor = Distributor::factory()->create();
    $tax = Tax::factory()->create([
        'rate' => 0.16,
    ]);

    $printerA = Printer::factory()->create([
        'sale_id' => null,
        'final_sale_price' => null,
    ]);

    $printerB = Printer::factory()->create([
        'sale_id' => null,
        'final_sale_price' => null,
    ]);

    Livewire::test(CreateSale::class)
        ->fillForm([
            'distributor_id' => $distributor->id,
            'invoice_number' => 'FAC-1001',
            'sale_date' => now()->toDateString(),
            'global_discount' => 15,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    $sale = Sale::query()->where('invoice_number', 'FAC-1001')->firstOrFail();

    $sale->saleItems()->create([
        'printer_id' => $printerA->id,
        'tax_id' => $tax->id,
        'unit_price' => 1000,
        'discount' => 50,
        'applied_tax_rate' => 0.16,
    ]);

    $sale->saleItems()->create([
        'printer_id' => $printerB->id,
        'tax_id' => $tax->id,
        'unit_price' => 1200,
        'discount' => 0,
        'applied_tax_rate' => 0.16,
    ]);

    expect($sale->saleItems()->count())->toBe(2);

    assertDatabaseHas(SaleItem::class, [
        'sale_id' => $sale->id,
        'printer_id' => $printerA->id,
        'unit_price' => 1000,
    ]);

    assertDatabaseHas(Printer::class, [
        'id' => $printerA->id,
        'sale_id' => $sale->id,
        'final_sale_price' => 1000,
    ]);

    assertDatabaseHas(Printer::class, [
        'id' => $printerB->id,
        'sale_id' => $sale->id,
        'final_sale_price' => 1200,
    ]);
});

it('prevents assigning a printer that already belongs to another sale', function () {
    $firstSale = Sale::factory()->create();
    $secondSale = Sale::factory()->create();

    $tax = Tax::factory()->create([
        'rate' => 0.16,
    ]);

    $printer = Printer::factory()->create([
        'sale_id' => $firstSale->id,
    ]);

    expect(function () use ($secondSale, $printer, $tax): void {
        SaleItem::query()->create([
            'sale_id' => $secondSale->id,
            'printer_id' => $printer->id,
            'tax_id' => $tax->id,
            'unit_price' => 1000,
            'discount' => 0,
            'applied_tax_rate' => 0.16,
        ]);
    })->toThrow(ValidationException::class);
});
