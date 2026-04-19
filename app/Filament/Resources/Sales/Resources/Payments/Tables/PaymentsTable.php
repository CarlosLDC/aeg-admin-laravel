<?php

namespace App\Filament\Resources\Sales\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_method')
                    ->label('Método de Pago')
                    ->badge()
                    ->searchable(),
                TextColumn::make('reference_number')
                    ->label('Referencia')
                    ->searchable(),
                TextColumn::make('currency')
                    ->label('Moneda')
                    ->badge(),
                TextColumn::make('amount')
                    ->label('Monto Base')
                    ->money()
                    ->sortable(),
                TextColumn::make('igtf_amount')
                    ->label('Monto IGTF')
                    ->money()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Monto Total')
                    ->money()
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label('Fecha de Pago')
                    ->dateTime()
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
