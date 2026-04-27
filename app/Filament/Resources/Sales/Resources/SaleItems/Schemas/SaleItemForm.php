<?php

namespace App\Filament\Resources\Sales\Resources\SaleItems\Schemas;

use App\Models\Printer;
use App\Models\SaleItem;
use App\Models\Tax;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SaleItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('printer_id')
                    ->label('Serial Fiscal')
                    ->relationship(
                        name: 'printer',
                        titleAttribute: 'fiscal_serial_number',
                        modifyQueryUsing: function (Builder $query, ?SaleItem $record): Builder {
                            return $query->where(function (Builder $printerQuery) use ($record) {
                                $printerQuery->whereNull('sale_id');

                                if ($record?->printer_id) {
                                    $printerQuery->orWhereKey($record->printer_id);
                                }
                            });
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->distinct()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        if (! $state) {
                            $set('unit_price', null);

                            return;
                        }

                        $printer = Printer::query()
                            ->with('printerModel:id,price')
                            ->find($state);

                        if ($printer) {
                            $set('unit_price', $printer->final_sale_price ?? $printer->printerModel?->price);
                        }
                    }),
                TextInput::make('unit_price')
                    ->label('Precio de Venta Final')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('discount')
                    ->label('Descuento')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->lte('unit_price')
                    ->default(0),
                Select::make('tax_id')
                    ->label('Alícuota')
                    ->relationship(
                        name: 'tax',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query,
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (Tax $tax): string => $tax->name.(! $tax->is_active ? ' (Inactiva)' : '')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        if (! $state) {
                            $set('applied_tax_rate', null);

                            return;
                        }

                        $tax = Tax::find($state);

                        if ($tax) {
                            $set('applied_tax_rate', $tax->rate);
                        }
                    }),
                TextInput::make('applied_tax_rate')
                    ->label('Alícuota Aplicada')
                    ->required()
                    ->readOnly(),
            ]);
    }
}
