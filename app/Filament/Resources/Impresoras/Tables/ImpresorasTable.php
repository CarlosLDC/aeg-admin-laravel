<?php

namespace App\Filament\Resources\Impresoras\Tables;

use App\Enums\DeviceType;
use App\Enums\ImpresoraStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImpresorasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('printerModel.name')
                    ->label('Modelo de Impresora')
                    ->searchable(),
                TextColumn::make('serial_fiscal')
                    ->label('Serial Fiscal')
                    ->searchable(),
                TextColumn::make('estatus')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (ImpresoraStatus|string|null $state): string => match ($state instanceof ImpresoraStatus ? $state : ImpresoraStatus::tryFrom((string) $state)) {
                        ImpresoraStatus::Laboratorio => 'gray',
                        ImpresoraStatus::Instalada => 'success',
                        ImpresoraStatus::Mantenimiento => 'warning',
                        ImpresoraStatus::Retirada => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('tipo_dispositivo')
                    ->label('Tipo de Dispositivo')
                    ->badge()
                    ->color(fn (DeviceType|string|null $state): string => match ($state instanceof DeviceType ? $state : DeviceType::tryFrom((string) $state)) {
                        DeviceType::Interno => 'gray',
                        DeviceType::Externo => 'primary',
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
                    ->label('Firmware')
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
