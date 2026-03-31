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
                    ->unique()
                    ->relationship('branch', 'trade_name')
                    ->searchable()
                    ->validationMessages([
                        'unique' => 'Esta sucursal ya está registrada como cliente.',
                    ]),
                Select::make('distributor_id')
                    ->label('Distribuidor')
                    ->different('distributor_id')
                    ->options(Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->pluck('branches.trade_name', 'distributors.id'))
                    ->searchable()
                    ->validationMessages([
                        'different' => 'Un cliente no puede ser su propio distribuidor.',
                    ]),
            ]);
    }
}
