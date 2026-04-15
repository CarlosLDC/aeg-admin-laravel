<?php

namespace App\Filament\Resources\Distributors\RelationManagers;

use App\Filament\Resources\Distributors\Resources\DistributorContacts\DistributorContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DistributorContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'DistributorContacts';

    protected static ?string $relatedResource = DistributorContactResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
