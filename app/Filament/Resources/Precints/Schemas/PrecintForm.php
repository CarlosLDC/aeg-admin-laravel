<?php

namespace App\Filament\Resources\Precints\Schemas;

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrecintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('printer_id')
                    ->label('Impresora')
                    ->relationship('printer', 'fiscal_serial_number')
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
                    ->options(ColorPrecint::class),
                Select::make('estatus')
                    ->label('Estatus')
                    ->required()
                    ->options(EstatusPrecint::class),
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
