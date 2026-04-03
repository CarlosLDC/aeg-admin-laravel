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
                    ->required()
                    ->numeric(),
                Toggle::make('is_active')
                    ->label('Activa')
                    ->required()
                    ->default(true),
            ]);
    }
}
