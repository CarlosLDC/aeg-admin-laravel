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
                    ->after('start_date')
                    ->validationMessages([
                        'after' => 'La fecha de finalización debe ser posterior a la fecha de inicio.',
                    ]),  
                TextInput::make('photo_path')
                    ->label('Ruta de la Foto del Contrato')
                    ->required()
                    ->unique()
                    ->url()
                    ->placeholder('http://example.com/contrato.jpg')
                    ->columnSpanFull()
                    ->copyable()
                    ->validationMessages([
                        'unique' => 'Este contrato ya tiene una foto asociada. Por favor, ingrese una ruta de foto diferente.',
                        'url' => 'Por favor, ingrese una URL válida.',
                    ])
            ]);
    }
}
