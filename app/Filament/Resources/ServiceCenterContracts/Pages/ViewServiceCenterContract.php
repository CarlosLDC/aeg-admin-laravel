<?php

namespace App\Filament\Resources\ServiceCenterContracts\Pages;

use App\Filament\Resources\ServiceCenterContracts\ServiceCenterContractResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCenterContract extends ViewRecord
{
    protected static string $resource = ServiceCenterContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
