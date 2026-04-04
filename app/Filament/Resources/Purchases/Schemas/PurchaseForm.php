<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Filament\Support\DistributorSelect;
use App\Models\Distributor;
use App\Models\PrinterModel;
use App\Models\Tax;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        $calcularTotalLinea = function (Get $get) 
        {
            $cantidad = floatval($get('quantity') ?: 0);
            $precio = floatval($get('unit_price') ?: 0);
            $descuento = floatval($get('discount') ?: 0);

            return max(0, ($cantidad * $precio) - $descuento);
        };

        return $schema
            ->components([
                Select::make('distributor_id')
                    ->label('Distribuidora')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                    ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                TextInput::make('invoice_number')
                    ->label('Número de Factura')
                    ->unique()
                    ->required()
                    ->validationMessages([
                        'unique' => 'El número de factura ya existe. Por favor, ingrese un número de factura único.',
                    ]),
                DatePicker::make('purchase_date')
                    ->label('Fecha de Compra')
                    ->required(),
                TextInput::make('global_discount')
                    ->label('Descuento Global')
                    ->required()
                    ->numeric()
                    ->step(5)
                    ->prefix('$')
                    ->default(0)
                    ->gte(0)
                    ->validationMessages([
                        'gte' => 'El descuento global debe ser mayor o igual que cero.',
                    ]),
                Section::make('Detalles de la Compra')
                    ->description('Agregue los productos adquiridos en esta factura.')
                    ->schema([
                        Repeater::make('purchaseItems')
                            ->hiddenLabel()
                            ->relationship()
                            ->schema([
                                Select::make('printer_model_id')
                                    ->label('Modelo de Impresora')
                                    ->required()
                                    ->relationship('printerModel')
                                    ->getOptionLabelFromRecordUsing(fn(PrinterModel $record) => "{$record->brand}-{$record->model}")
                                    ->searchable(['brand', 'model'])
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (blank($state)) {
                                            $set('unit_price', null);
                                            return;
                                        }

                                        $printer = PrinterModel::find($state);

                                        if ($printer) {
                                            $set('unit_price', $printer->price);
                                        }
                                    }),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->required()
                                    ->numeric()
                                    ->gte(1)
                                    ->validationMessages([
                                        'gte' => 'Debe ingresar al menos una unidad.',
                                    ]),
                                TextInput::make('unit_price')
                                    ->label('Precio Unitario')
                                    ->required()
                                    ->numeric()
                                    ->step(5)
                                    ->prefix('$')
                                    ->default(fn(callable $get) => $get('printer_model_id') ? PrinterModel::find($get('printer_model_id'))->price : 0)
                                    ->gt(0)
                                    ->validationMessages([
                                        'gt' => 'El precio unitario debe ser mayor que cero.',
                                    ]),
                                TextInput::make('discount')
                                    ->label('Descuento')
                                    ->required()
                                    ->numeric()
                                    ->step(5)
                                    ->prefix('$')
                                    ->default(0)
                                    ->gte(0)
                                    ->validationMessages([
                                        'gte' => 'El descuento debe ser mayor o igual que cero.',
                                    ]),
                                Select::make('tax_id')
                                    ->label('Impuesto')
                                    ->required()
                                    ->relationship(name: 'tax', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true))
                                    ->getOptionLabelFromRecordUsing(fn(Tax $record) => $record->name . ' (' . ($record->rate * 100) . '%)')
                                    ->searchable('name')
                                    ->preload(),

                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Añadir otro producto'),
                    ])
                    ->columnSpan('full'),
            ]);
    }
}
