<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistributorContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Fecha de Finalización')
                    ->required()
                    ->after('start_date'),
                TextInput::make('photo_path')
                    ->label('Ruta de la Foto del Contrato')
                    ->required()
                    ->unique()
                    ->url()
                    ->placeholder('http://example.com/contrato.jpg')
                    ->columnSpanFull()
                    ->copyable(),
            ]);
    }
}
