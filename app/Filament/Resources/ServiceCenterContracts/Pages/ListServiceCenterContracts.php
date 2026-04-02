<?php

namespace App\Filament\Resources\ServiceCenterContracts\Pages;

use App\Filament\Resources\ServiceCenterContracts\ServiceCenterContractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiceCenterContracts extends ListRecords
{
    protected static string $resource = ServiceCenterContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
