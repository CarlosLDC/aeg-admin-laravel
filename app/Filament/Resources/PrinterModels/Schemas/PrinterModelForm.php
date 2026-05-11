<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use App\Enums\DeviceType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PrinterModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('brand')
                                            ->label('Marca')
                                            ->required()
                                            ->default('AEG'),
                                        TextInput::make('model')
                                            ->label('Modelo')
                                            ->required()
                                            ->placeholder('R1'),
                                        Select::make('device_type')
                                            ->label('Tipo de Dispositivo')
                                            ->required()
                                            ->options(DeviceType::class)
                                            ->default(DeviceType::Internal->value),
                                        TextInput::make('price')
                                            ->label('Precio')
                                            ->required()
                                            ->numeric()
                                            ->gt('0')
                                            ->prefix('$')
                                            ->placeholder('1000'),
                                    ]),
                            ]),
                        Tab::make('Información Fiscal')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('administrative_act')
                                            ->label('Providencia')
                                            ->regex('/^SNAT\/\d{4}\/\d{4,6}$/i')
                                            ->placeholder('SNAT/2025/0001'),
                                        DatePicker::make('certification_date')
                                            ->label('Fecha de Homologación'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
