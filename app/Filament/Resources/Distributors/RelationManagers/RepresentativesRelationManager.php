<?php

namespace App\Filament\Resources\Distributors\RelationManagers;

use App\Filament\Resources\Distributors\Resources\Representatives\RepresentativeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class RepresentativesRelationManager extends RelationManager
{
    protected static string $relationship = 'representatives';

    protected static ?string $relatedResource = RepresentativeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
