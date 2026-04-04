<?php

namespace App\Filament\Resources\Purchases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->searchable(),
                TextColumn::make('invoice_number')
                    ->label('Número de Factura')
                    ->searchable(),
                TextColumn::make('purchase_date')
                    ->label('Fecha de Compra')
                    ->date()
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('global_discount')
                    ->label('Descuento Global')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('total_tax')
                    ->label('Impuesto Total')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->numeric()
                    ->prefix('$')
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
