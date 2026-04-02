<?php

namespace App\Filament\Resources\Companies\Tables;

use App\Enums\TaxpayerType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('legal_name')
                    ->label('Razón Social')
                    ->searchable(),
                TextColumn::make('tax_id')
                    ->label('RIF')
                    ->searchable(),
                TextColumn::make('taxpayer_type')
                    ->label('Tipo de Contribuyente')
                    ->searchable()
                    ->badge()
                    ->color(fn(TaxpayerType $state): string => match ($state) {
                        TaxpayerType::Ordinary => 'primary',
                        TaxpayerType::Special => 'success',
                        TaxpayerType::Formal => 'gray',
                    }),
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
