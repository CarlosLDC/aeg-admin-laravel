<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Pages;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\ServiceCenterContractResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServiceCenterContract extends EditRecord
{
    protected static string $resource = ServiceCenterContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
