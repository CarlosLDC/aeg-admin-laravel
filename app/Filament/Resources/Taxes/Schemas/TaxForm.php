<?php

namespace App\Filament\Resources\Taxes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TaxForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('rate')
                    ->label('Tasa')
                    ->helperText('Escriba en formato decimal. Ejemplo: 0.16 para el 16%.')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1),
                Toggle::make('is_active')
                    ->label('Activa')
                    ->required()
                    ->default(true),
            ]);
    }
}
