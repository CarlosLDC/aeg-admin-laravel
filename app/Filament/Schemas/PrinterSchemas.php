<?php

namespace App\Filament\Schemas;

use App\Enums\PrinterStatus;
use App\Models\Client;
use App\Models\Tax;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class PrinterSchemas
{
    public static function form(): array
    {
        return [
            Grid::make(12)
                ->schema([
                    Section::make('Identificación')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('fiscal_serial_number')
                                        ->label('Serial Fiscal')
                                        ->required()
                                        ->unique()
                                        ->regex('/^[a-zA-Z]{3}[0-9]{7}$/')
                                        ->placeholder('ABC1234567'),
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
                                    DatePicker::make('installation_date')
                                        ->label('Fecha de Instalación'),
                                    Select::make('client_id')
                                        ->label('Cliente')
                                        ->searchable()
                                        ->getSearchResultsUsing(
                                            fn(string $search): array => Client::query()
                                                ->join('branches', 'clients.branch_id', '=', 'branches.id')
                                                ->where('branches.trade_name', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->pluck('branches.trade_name', 'clients.id')
                                                ->all()
                                        )
                                        ->getOptionLabelUsing(
                                            fn(string $value): ?string => Client::query()
                                                ->join('branches', 'clients.branch_id', '=', 'branches.id')
                                                ->where('clients.id', $value)
                                                ->value('branches.trade_name')
                                        )
                                        ->columnSpanFull(),
                                    ToggleButtons::make('status')
                                        ->label('Estatus')
                                        ->options(PrinterStatus::class)
                                        ->default(PrinterStatus::Testing->value)
                                        ->inline()
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->columnSpan(8),
                    Section::make('Especificaciones Ténicas')
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
                        ])
                        ->columnSpan(4),
                    Section::make('Información de Venta')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Select::make('sale_id')
                                        ->label('Número de Factura')
                                        ->relationship('sale', 'invoice_number')
                                        ->searchable()
                                        ->preload()
                                        ->placeholder('12345678'),
                                    TextInput::make('final_sale_price')
                                        ->label('Precio de Venta Final')
                                        ->numeric()
                                        ->minValue(0)
                                        ->prefix('$')
                                        ->placeholder('1000'),
                                    Select::make('tax_id')
                                        ->label('Alícuota')
                                        ->relationship('tax', 'name')
                                        ->getOptionLabelFromRecordUsing(
                                            fn(Tax $tax): string => $tax->name . (! $tax->is_active ? ' (Inactiva)' : '')
                                        )
                                        ->searchable()
                                        ->preload(),
                                ]),
                            Toggle::make('is_paid')
                                ->label('Pagada'),
                        ])
                        ->columnSpan(8)
                        ->collapsed(),
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
            TextColumn::make('client.branch.trade_name')
                ->label('Cliente')
                ->searchable(),
            TextColumn::make('installation_date')
                ->label('Fecha de Instalación')
                ->date()
                ->sortable(),
            TextColumn::make('sale.invoice_number')
                ->label('Número de Factura')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('final_sale_price')
                ->label('Precio de Venta Final')
                ->money()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('tax.name')
                ->label('Alícuota')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('is_paid')
                ->label('Pagada')
                ->boolean()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
