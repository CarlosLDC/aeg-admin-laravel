<?php

namespace App\Filament\Resources\ServiceCenters\RelationManagers;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\ServiceCenterContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ServiceCenterContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'ServiceCenterContacts';

    protected static ?string $relatedResource = ServiceCenterContactResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
