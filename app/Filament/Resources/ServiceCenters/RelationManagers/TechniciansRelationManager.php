<?php

namespace App\Filament\Resources\ServiceCenters\RelationManagers;

use App\Filament\Resources\Technicians\TechnicianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class TechniciansRelationManager extends RelationManager
{
    protected static string $relationship = 'technicians';

    protected static ?string $relatedResource = TechnicianResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
