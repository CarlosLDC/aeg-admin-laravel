<?php

namespace App\Filament\Resources\Branches\Tables;

use App\Enums\BranchRoles;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trade_name')
                    ->label('Nombre Comercial')
                    ->searchable(),
                TextColumn::make('company.tax_id')
                    ->label('RIF')
                    ->searchable(),
                IconColumn::make('roles')
                    ->icon(fn (string $state): Heroicon => match ($state) {
                        BranchRoles::Distributor->value => Heroicon::Truck,
                        BranchRoles::ServiceCenter->value => Heroicon::WrenchScrewdriver,
                        BranchRoles::SoftwareProvider->value => Heroicon::ComputerDesktop,
                        BranchRoles::Client->value => Heroicon::BuildingStorefront,
                    }),
                TextColumn::make('state')
                    ->label('Estado')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Ciudad')
                    ->searchable(),
                TextColumn::make('phone_primary')
                    ->label('Teléfono Principal')
                    ->searchable(),
                TextColumn::make('phone_secondary')
                    ->label('Teléfono Secundario')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                TextColumn::make('contact_person')
                    ->label('Persona de Contacto')
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
