<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.trade_name')
                    ->label('Sucursal')
                    ->searchable(),
                TextColumn::make('branch.company.tax_id')
                    ->label('RIF')
                    ->searchable(),
                TextColumn::make('branch.state')
                    ->label('Estado')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.city')
                    ->label('Ciudad')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.phone')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('branch.email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                TextColumn::make('branch.contact_person')
                    ->label('Persona de Contacto')
                    ->searchable(),
                TextColumn::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->searchable(),
                TextColumn::make('distributor.branch.company.tax_id')
                    ->label('RIF de la Distribuidora')
                    ->searchable(),
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
