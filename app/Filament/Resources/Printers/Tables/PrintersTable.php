<?php

namespace App\Filament\Resources\Printers\Tables;

use App\Enums\DeviceType;
use App\Enums\PrinterStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrintersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('printerModel.search_name')
                    ->label('Modelo de Impresora')
                    ->searchable(),
                TextColumn::make('serial_fiscal')
                    ->label('Serial Fiscal')
                    ->searchable(),
                TextColumn::make('estatus')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (PrinterStatus|string|null $state): string => match ($state instanceof PrinterStatus ? $state : PrinterStatus::tryFrom((string) $state)) {
                        PrinterStatus::Testing => 'gray',
                        PrinterStatus::Installed => 'success',
                        PrinterStatus::Maintenance => 'warning',
                        PrinterStatus::Retired => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('tipo_dispositivo')
                    ->label('Tipo de Dispositivo')
                    ->badge()
                    ->color(fn (DeviceType|string|null $state): string => match ($state instanceof DeviceType ? $state : DeviceType::tryFrom((string) $state)) {
                        DeviceType::Internal => 'gray',
                        DeviceType::External => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('precio_venta_final')
                    ->label('Precio de Venta Final')
                    ->money()
                    ->sortable(),
                TextColumn::make('branch.trade_name')
                    ->label('Sucursal')
                    ->searchable(),
                TextColumn::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->searchable(),
                TextColumn::make('firmware.version')
                    ->label('Versión de Firmware')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
