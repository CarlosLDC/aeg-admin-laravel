<?php

namespace App\Filament\Resources\SoftwareProviders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SoftwareProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('tax_id')
                    ->label('RIF')
                    ->required()
                    ->placeholder('J123456789')
                    ->regex('/^[VEJPG][0-9]{9}$/')
                    ->validationMessages([
                        'regex' => 'El RIF debe comenzar con V, E, J, P o G (en mayúsculas) seguido de 9 dígitos. No separe los dígitos. Si tiene menos de 9 dígitos, complete con ceros a la izquierda (ejemplo: J012345678).',
                    ]),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
                TextInput::make('contact_person')
                    ->label('Persona de Contacto')
                    ->required(),
            ]);
    }
}
