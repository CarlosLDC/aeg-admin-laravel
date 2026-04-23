<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use App\Enums\DeviceType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
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
                    ->default('AEG'),
                TextInput::make('model')
                    ->label('Modelo')
                    ->required(),
                Select::make('device_type')
                    ->label('Tipo de Dispositivo')
                    ->required()
                    ->options(DeviceType::class)
                    ->default(DeviceType::Internal->value)
                    ->native(false),
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->gt('0')
                    ->prefix('$'),
                TextInput::make('administrative_act')
                    ->label('Providencia')
                    ->required()
                    ->regex('/^SNAT\/\d{4}\/\d{4,6}$/i')
                    ->placeholder('SNAT/2025/0001'),
                DatePicker::make('certification_date')
                    ->label('Fecha de Homologación')
                    ->required(),
            ]);
    }
}
