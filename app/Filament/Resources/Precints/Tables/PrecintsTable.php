<?php

namespace App\Filament\Resources\Precints\Tables;

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrecintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serial')
                    ->label('Serial')
                    ->searchable(),
                TextColumn::make('printer.fiscal_serial_number')
                    ->label('Serial Fiscal de Impresora')
                    ->searchable(),
                TextColumn::make('color')
                    ->label('Color')
                    ->badge()
                    ->color(fn (ColorPrecint|string|null $state): string => match ($state instanceof ColorPrecint ? $state : ColorPrecint::tryFrom((string) $state)) {
                        ColorPrecint::Blanco => 'gray',
                        ColorPrecint::Amarillo => 'warning',
                        ColorPrecint::Azul => 'primary',
                        ColorPrecint::Rojo => 'danger',
                        ColorPrecint::Verde => 'success',
                        ColorPrecint::Negro => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('estatus')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (EstatusPrecint|string|null $state): string => match ($state instanceof EstatusPrecint ? $state : EstatusPrecint::tryFrom((string) $state)) {
                        EstatusPrecint::Disponible => 'success',
                        EstatusPrecint::Instalado => 'primary',
                        EstatusPrecint::Retirado => 'warning',
                        EstatusPrecint::Anulado => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('fecha_instalacion')
                    ->label('Fecha de Instalación')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_retiro')
                    ->label('Fecha de Retiro')
                    ->dateTime()
                    ->sortable(),
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
