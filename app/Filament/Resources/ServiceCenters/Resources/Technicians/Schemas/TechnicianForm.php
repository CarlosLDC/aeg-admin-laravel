<?php

namespace App\Filament\Resources\ServiceCenters\Resources\Technicians\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechnicianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('national_id')
                    ->label('Cédula')
                    ->placeholder('V12345678')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Debe comenzar con V o E (en mayúsculas) seguido de 7 u 8 dígitos, sin espacios ni separadores. Ejemplo: V12345678.')
                    ->required()
                    ->unique()
                    ->regex('/^[VE][0-9]{7,8}$/'),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
            ]);
    }
}
