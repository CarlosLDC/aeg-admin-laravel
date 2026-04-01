<?php

namespace App\Filament\Resources\SoftwareProviders\RelationManagers;

use App\Filament\Resources\Software\SoftwareResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SoftwareRelationManager extends RelationManager
{
    protected static string $relationship = 'software';

    protected static ?string $relatedResource = SoftwareResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
