<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Filament\Support\DistributorSelect;
use App\Filament\Support\SearchPromptText;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('distributor_id')
                    ->label('Distribuidora')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                    ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                    ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId()),
                TextInput::make('invoice_number')
                    ->label('Número de Factura')
                    ->unique()
                    ->required(),
                DatePicker::make('sale_date')
                    ->label('Fecha de Venta')
                    ->required(),
                TextInput::make('global_discount')
                    ->label('Descuento Global')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Fieldset::make('Totales')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('$')
                            ->default(0)
                            ->live()
                            ->readOnly(),
                        TextInput::make('total_tax')
                            ->label('Total de Impuestos')
                            ->prefix('$')
                            ->default(0)
                            ->live()
                            ->readOnly(),
                        TextInput::make('total')
                            ->label('Total')
                            ->prefix('$')
                            ->default(0)
                            ->live()
                            ->readOnly(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }
}
