<?php

namespace App\Filament\Resources\Precintos\Tables;

use App\Enums\ColorPrecinto;
use App\Enums\EstatusPrecinto;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrecintosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('impresora.serial_fiscal')
                    ->label('Impresora')
                    ->searchable(),
                TextColumn::make('serial')
                    ->label('Serial')
                    ->searchable(),
                TextColumn::make('color')
                    ->label('Color')
                    ->badge()
                    ->color(fn (ColorPrecinto|string|null $state): string => match ($state instanceof ColorPrecinto ? $state : ColorPrecinto::tryFrom((string) $state)) {
                        ColorPrecinto::Blanco => 'gray',
                        ColorPrecinto::Amarillo => 'warning',
                        ColorPrecinto::Azul => 'primary',
                        ColorPrecinto::Rojo => 'danger',
                        ColorPrecinto::Verde => 'success',
                        ColorPrecinto::Negro => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('estatus')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (EstatusPrecinto|string|null $state): string => match ($state instanceof EstatusPrecinto ? $state : EstatusPrecinto::tryFrom((string) $state)) {
                        EstatusPrecinto::Disponible => 'success',
                        EstatusPrecinto::Instalado => 'primary',
                        EstatusPrecinto::Retirado => 'warning',
                        EstatusPrecinto::Anulado => 'gray',
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
