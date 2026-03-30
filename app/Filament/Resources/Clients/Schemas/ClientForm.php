<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\Branch;
use App\Models\Distributor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label('Sucursal')
                    ->required()
                    ->options(Branch::query()->pluck('trade_name', 'id'))
                    ->searchable(),
                Select::make('distributor_id')
                    ->label('Distribuidor')
                    ->options(Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->pluck('branches.trade_name', 'distributors.id'))
                    ->searchable(),
            ]);
    }
}
