<?php

namespace App\Filament\Resources\DistributorContracts\Pages;

use App\Filament\Resources\DistributorContracts\DistributorContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistributorContracts extends ListRecords
{
    protected static string $resource = DistributorContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
