<?php

namespace App\Filament\Resources\Distributors\Schemas;

use App\Filament\Support\BranchSelect;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class DistributorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label('Sucursal')
                    ->required()
                    ->unique()
                    ->searchable()
                    ->getSearchResultsUsing(BranchSelect::searchResults(...))
                    ->getOptionLabelUsing(BranchSelect::optionLabel(...))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
            ]);
    }
}
