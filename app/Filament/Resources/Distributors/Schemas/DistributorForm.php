<?php

namespace App\Filament\Resources\Distributors\Schemas;

use App\Models\Branch;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                    ->options(Branch::query()->pluck('trade_name', 'id'))
                    ->searchable()
                    ->validationMessages([
                        'unique' => 'Esta sucursal ya está registrada como distribuidor.',
                    ]),
            ]);
    }
}
