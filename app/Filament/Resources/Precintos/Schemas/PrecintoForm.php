<?php

namespace App\Filament\Resources\Precintos\Schemas;

use App\Enums\ColorPrecinto;
use App\Enums\EstatusPrecinto;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrecintoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_impresora')
                    ->label('Impresora')
                    ->relationship('impresora', 'serial_fiscal')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('serial')
                    ->label('Serial')
                    ->required()
                    ->regex('/^[A-Z0-9]{10,16}$/')
                    ->placeholder('AB12CD34EF'),
                Select::make('color')
                    ->label('Color')
                    ->required()
                    ->options(ColorPrecinto::class),
                Select::make('estatus')
                    ->label('Estatus')
                    ->required()
                    ->options(EstatusPrecinto::class),
                DateTimePicker::make('fecha_instalacion')
                    ->label('Fecha de Instalación')
                    ->seconds(false)
                    ->native(false)
                    ->nullable(),
                DateTimePicker::make('fecha_retiro')
                    ->label('Fecha de Retiro')
                    ->seconds(false)
                    ->native(false)
                    ->nullable(),
            ]);
    }
}
