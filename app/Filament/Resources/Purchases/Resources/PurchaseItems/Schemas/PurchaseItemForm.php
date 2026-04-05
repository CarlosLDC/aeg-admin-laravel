<?php

namespace App\Filament\Resources\Purchases\Resources\PurchaseItems\Schemas;

use App\Models\PrinterModel;
use App\Models\PurchaseItem;
use App\Models\Tax;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PurchaseItemForm
{
    public static function configure(Schema $schema): Schema
    {
        $recalculateTotals = function (Get $get, Set $set) {
            $item = new PurchaseItem([
                'quantity' => (int) max(1, ($get('quantity') ?? 0)),
                'unit_price' => (float) max(0, ($get('unit_price') ?? 0)),
                'discount' => (float) max(0, ($get('discount') ?? 0)),
                'applied_tax_rate' => (float) max(0, ($get('applied_tax_rate') ?? 0)),
            ])->recalculateTotals();

            $set('line_total', round($item->line_total, 2));
            $set('tax_amount', round($item->tax_amount, 2));
            $set('grand_total', round($item->grand_total, 2));
        };

        return $schema
            ->components([
                Select::make('printer_model_id')
                    ->label('Producto')
                    ->relationship('printerModel', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) use ($recalculateTotals) {
                        if (! $state) {
                            $set('unit_price', null);
                            $recalculateTotals($get, $set);

                            return;
                        }

                        $product = PrinterModel::find($state);

                        if ($product) {
                            $set('unit_price', $product->price);
                            $recalculateTotals($get, $set);
                        }
                    }),
                TextInput::make('unit_price')
                    ->label('Precio Unitario')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->live(debounce: 500)
                    ->afterStateUpdated($recalculateTotals)
                    ->disabled(fn(Get $get) => ! $get('printer_model_id')),
                TextInput::make('quantity')
                    ->label('Cantidad')
                    ->required()
                    ->integer()
                    ->step(1)
                    ->minValue(1)
                    ->default(1)
                    ->live(debounce: 500)
                    ->afterStateUpdated($recalculateTotals),
                TextInput::make('discount')
                    ->label('Descuento')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->lte('unit_price')
                    ->default(0)
                    ->live(debounce: 500)
                    ->afterStateUpdated($recalculateTotals),
                Select::make('tax_id')
                    ->label('Alícuota')
                    ->relationship('tax', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) use ($recalculateTotals) {
                        if (! $state) {
                            $set('applied_tax_rate', null);
                            $recalculateTotals($get, $set);

                            return;
                        }

                        $tax = Tax::find($state);

                        if ($tax) {
                            $set('applied_tax_rate', $tax->rate);
                            $recalculateTotals($get, $set);
                        }
                    }),
                TextInput::make('applied_tax_rate')
                    ->label('Alícuota Aplicada')
                    ->required()
                    ->readOnly()
                    ->disabled(fn(Get $get) => ! $get('tax_id')),
                Fieldset::make('Totales')
                    ->schema([
                        TextInput::make('line_total')
                            ->label('Subtotal')
                            ->prefix('$')
                            ->default(0)
                            ->readOnly()
                            ->dehydrated(false),
                        TextInput::make('tax_amount')
                            ->label('Importe del Impuesto')
                            ->prefix('$')
                            ->default(0)
                            ->readOnly()
                            ->dehydrated(false),
                        TextInput::make('grand_total')
                            ->label('Total')
                            ->prefix('$')
                            ->default(0)
                            ->readOnly()
                            ->dehydrated(false),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
