<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrinterModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('brand')
                    ->label('Marca')
                    ->required()
                    ->default('AEG')
                    ->readOnly(),
                TextInput::make('model')
                    ->label('Modelo')
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->gt('0'),
                TextInput::make('administrative_act')
                    ->label('Providencia')
                    ->required()
                    ->mask('aaaa/9999/9999')
                    ->placeholder('snat/2024/0001')
                    ->regex('/^[a-z]{4}\/\d{4}\/\d{4}$/'),
                DatePicker::make('certification_date')
                    ->label('Fecha de Homologación')
                    ->required(),
            ]);
    }
}
