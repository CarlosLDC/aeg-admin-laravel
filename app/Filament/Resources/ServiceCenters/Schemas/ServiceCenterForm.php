<?php

namespace App\Filament\Resources\ServiceCenters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ServiceCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label('Sucursal')
                    ->unique()
                    ->relationship('branch', 'trade_name')
                    ->searchable()
                    ->required()
                    ->validationMessages([
                        'unique' => 'Esta sucursal ya está registrada como centro de servicio.',
                    ]),
            ]);
    }
}
