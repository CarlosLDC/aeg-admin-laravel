<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Filament\Support\DistributorSelect;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseForm
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
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                TextInput::make('invoice_number')
                    ->label('Número de Factura')
                    ->unique()
                    ->required(),
                DatePicker::make('purchase_date')
                    ->label('Fecha de Compra')
                    ->required(),
                TextInput::make('global_discount')
                    ->label('Descuento Global')
                    ->prefix('$')
                    ->required()
                    ->numeric()
                    ->gte(0)
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}
