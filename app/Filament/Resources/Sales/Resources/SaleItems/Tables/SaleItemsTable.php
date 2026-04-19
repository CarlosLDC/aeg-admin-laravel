<?php

namespace App\Filament\Resources\Sales\Resources\SaleItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SaleItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('printerModel.name')
                    ->label('Impresora')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->label('Precio Unitario')
                    ->money()
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Descuento')
                    ->money()
                    ->sortable(),
                TextColumn::make('tax.name')
                    ->label('Alícuota')
                    ->searchable(),
                TextColumn::make('applied_tax_rate')
                    ->label('Alícuota Aplicada')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('line_total')
                    ->label('Subtotal')
                    ->money()
                    ->sortable(),
                TextColumn::make('tax_amount')
                    ->label('Importe del Impuesto')
                    ->money()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->label('Total')
                    ->money()
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
                EditAction::make()
                    ->successRedirectUrl(fn (): string => url()->previous()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->successRedirectUrl(fn (): string => url()->previous()),
                ]),
            ]);
    }
}
