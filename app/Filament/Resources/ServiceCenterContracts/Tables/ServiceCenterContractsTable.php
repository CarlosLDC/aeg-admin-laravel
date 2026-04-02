<?php

namespace App\Filament\Resources\ServiceCenterContracts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceCenterContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serviceCenter.branch.trade_name')
                    ->label('Centro de Servicio')
                    ->searchable(),
                TextColumn::make('serviceCenter.branch.company.tax_id')
                    ->label('RIF del Centro de Servicio')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Fecha de inicio')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fecha de finalización')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
