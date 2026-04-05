<?php

namespace App\Filament\Resources\Impresoras\Schemas;

use App\Enums\DeviceType;
use App\Enums\ImpresoraStatus;
use App\Filament\Support\DistributorSelect;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class ImpresoraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Identificación')
                    ->schema([
                        Select::make('id_modelo_impresora')
                            ->label('Modelo de Impresora')
                            ->required()
                            ->relationship('printerModel', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('serial_fiscal')
                            ->label('Serial Fiscal')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('ABC1234567')
                            ->regex('/^[A-Z]{3}[0-9]{7}$/'),
                        Select::make('estatus')
                            ->label('Estatus')
                            ->required()
                            ->options(ImpresoraStatus::class)
                            ->default(ImpresoraStatus::Laboratorio->value),
                        Select::make('tipo_dispositivo')
                            ->label('Tipo de Dispositivo')
                            ->required()
                            ->options(DeviceType::class)
                            ->default(DeviceType::Interno->value),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Fieldset::make('Relaciones')
                    ->schema([
                        Select::make('id_software')
                            ->label('Software')
                            ->relationship('software', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('id_compra')
                            ->label('Compra')
                            ->relationship('purchase', 'invoice_number')
                            ->searchable()
                            ->preload(),
                        Select::make('id_sucursal')
                            ->label('Sucursal')
                            ->relationship('branch', 'trade_name')
                            ->searchable()
                            ->preload(),
                        Select::make('id_firmware')
                            ->label('Firmware')
                            ->relationship('firmware', 'version')
                            ->searchable()
                            ->preload(),
                        Select::make('id_distribuidora')
                            ->label('Distribuidora')
                            ->searchable()
                            ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                            ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                            ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Fieldset::make('Detalles')
                    ->schema([
                        TextInput::make('precio_venta_final')
                            ->label('Precio de Venta Final')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$')
                            ->nullable(),
                        Toggle::make('se_pago')
                            ->label('Se Pagó')
                            ->default(false),
                        DateTimePicker::make('fecha_instalacion')
                            ->label('Fecha de Instalación')
                            ->seconds(false)
                            ->native(false)
                            ->nullable(),
                        TextInput::make('version_firmware')
                            ->label('Versión de Firmware')
                            ->placeholder('1.0.0')
                            ->regex('/^\d+\.\d+\.\d+$/')
                            ->nullable(),
                        TextInput::make('direccion_mac')
                            ->label('Dirección MAC')
                            ->placeholder('AA:BB:CC:DD:EE:FF')
                            ->regex('/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i')
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
