<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use App\Enums\DeviceType;
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
                TextInput::make('device_type')
                    ->label('Tipo de Dispositivo')
                    ->required()
                    ->options(DeviceType::cases())
                    ->default(DeviceType::Internal->value),
                TextInput::make('administrative_act')
                    ->label('Providencia')
                    ->required()
                    ->placeholder('SNAT/2025/0001')
                    ->regex('/^SNAT\/\d{4}\/\d{4,6}$/i'),
                DatePicker::make('certification_date')
                    ->label('Fecha de Homologación')
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->gt('0'),
            ]);
    }
}
