<?php

namespace App\Filament\Resources\ServiceCenters\RelationManagers;

use App\Filament\Resources\ServiceCenterContracts\ServiceCenterContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ServiceCenterContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceCenterContracts';

    protected static ?string $relatedResource = ServiceCenterContractResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
