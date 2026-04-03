<?php

namespace App\Filament\Resources\Distributors\Resources\Representatives\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RepresentativeForm
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
                    ->required()
                    ->unique()
                    ->regex('/^[VE][0-9]{7,8}$/')
                    ->validationMessages([
                        'unique' => 'Esta cédula ya está registrada para otro empleado.',
                        'regex' => 'La cédula debe comenzar con V o E (en mayúsculas) seguido de 7 u 8 dígitos, sin espacios ni separadores (ejemplo: V12345678).',
                    ]),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required()
                    ->validationMessages([
                        'tel' => 'Ingrese un número de teléfono válido.',
                    ]),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->validationMessages([
                        'email' => 'Ingrese una dirección de correo electrónico válida.',
                    ]),
            ]);
    }
}
