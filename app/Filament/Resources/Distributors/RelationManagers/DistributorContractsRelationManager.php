<?php

namespace App\Filament\Resources\Distributors\RelationManagers;

use App\Filament\Resources\Distributors\Resources\DistributorContracts\DistributorContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DistributorContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'distributorContracts';

    protected static ?string $relatedResource = DistributorContractResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
