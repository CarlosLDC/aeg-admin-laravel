<?php

namespace App\Filament\Schemas;

use App\Enums\PrinterStatus;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class PrinterSchemas
{
    public static function form(): array
    {
        return [
            Section::make('Identificación')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('fiscal_serial_number')
                                ->label('Serial Fiscal')
                                ->required()
                                ->unique()
                                ->placeholder('ABC1234567')
                                ->regex('/^[a-zA-Z]{3}[0-9]{7}$/'),
                            Select::make('printer_model_id')
                                ->label('Modelo de Impresora')
                                ->required()
                                ->relationship('printerModel', 'full_name')
                                ->searchable()
                                ->preload(),
                            TextInput::make('mac_address')
                                ->label('Dirección MAC')
                                ->macAddress()
                                ->placeholder('AA:BB:CC:DD:EE:FF'),
                        ]),
                ])
                ->columnSpanFull(),
            Section::make('Especificaciones Ténicas')
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('firmware_id')
                                ->label('Versión de Firmware')
                                ->relationship('firmware', 'version')
                                ->searchable()
                                ->preload(),
                            Select::make('software_id')
                                ->label('Software')
                                ->relationship('software', 'full_name')
                                ->searchable()
                                ->preload(),
                        ]),
                ])
                ->columnSpanFull(),
            Section::make('Estatus y Asignación')
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('status')
                                ->label('Estatus')
                                ->required()
                                ->options(PrinterStatus::class)
                                ->default(PrinterStatus::Testing->value),
                            Select::make('client_id')
                                ->label('Cliente')
                                ->relationship('client', 'id')
                                ->getOptionLabelFromRecordUsing(
                                    fn (Client $client) => $client->branch->trade_name
                                )
                                ->searchable()
                                ->preload(),
                            DatePicker::make('installation_date')
                                ->label('Fecha de Instalación'),
                        ]),
                ])
                ->columnSpanFull(),
            Section::make('Información de Venta')
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('sale_id')
                                ->label('Número de Factura')
                                ->relationship('sale', 'invoice_number')
                                ->searchable()
                                ->preload(),
                            TextInput::make('final_sale_price')
                                ->label('Precio de Venta Final')
                                ->numeric()
                                ->minValue(0)
                                ->prefix('$'),
                            Select::make('tax_id')
                                ->label('Alícuota')
                                ->relationship('tax', 'name')
                                ->preload(),
                        ]),
                    Toggle::make('is_paid')
                        ->label('Pagada'),
                ])
                ->columnSpanFull(),
            Section::make('Encabezados')
                ->schema([
                    KeyValue::make('headers')
                        ->hiddenLabel()
                        ->reorderable(),
                ])
                ->columnSpanFull(),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('fiscal_serial_number')
                ->label('Serial Fiscal')
                ->searchable(),
            TextColumn::make('printerModel.full_name')
                ->label('Modelo')
                ->searchable(),
            TextColumn::make('mac_address')
                ->label('Dirección MAC')
                ->searchable(),
            TextColumn::make('firmware.version')
                ->label('Versión de Firmware')
                ->searchable(),
            TextColumn::make('software.full_name')
                ->label('Software')
                ->searchable(),
            TextColumn::make('status')
                ->label('Estatus')
                ->badge()
                ->searchable(),
            TextColumn::make('client.id')
                ->label('Cliente')
                ->searchable(),
            TextColumn::make('installation_date')
                ->label('Fecha de Instalación')
                ->date()
                ->sortable(),
            TextColumn::make('sale.invoice_number')
                ->label('Número de Factura')
                ->searchable(),
            TextColumn::make('final_sale_price')
                ->label('Precio de Venta Final')
                ->money()
                ->sortable(),
            TextColumn::make('tax.name')
                ->label('Alícuota')
                ->searchable(),
            IconColumn::make('is_paid')
                ->label('Pagada')
                ->boolean()
                ->sortable(),
        ];
    }
}
