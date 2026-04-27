<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Filament\Support\DistributorSelect;
use App\Filament\Support\SearchPromptText;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make('12')
                    ->schema([
                        Section::make('Información de Venta')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextInput::make('invoice_number')
                                            ->label('Número de Factura')
                                            ->unique()
                                            ->required(),
                                        DatePicker::make('sale_date')
                                            ->label('Fecha de Venta')
                                            ->required(),
                                        Select::make('distributor_id')
                                            ->label('Distribuidora')
                                            ->required()
                                            ->searchable()
                                            ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                                            ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                                            ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId())
                                            ->columnSpanFull(),
                                        TextInput::make('global_discount')
                                            ->label('Descuento Global')
                                            ->prefix('$')
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(0)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpan('8'),
                        Section::make('Resumen de Totales')
                            ->schema([
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->prefix('$')
                                    ->default(0)
                                    ->disabled(),
                                TextInput::make('total_tax')
                                    ->label('Total de Impuestos')
                                    ->prefix('$')
                                    ->default(0)
                                    ->disabled(),
                                TextInput::make('total')
                                    ->label('Total')
                                    ->prefix('$')
                                    ->default(0)
                                    ->disabled(),
                            ])
                            ->columnSpan('4'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
