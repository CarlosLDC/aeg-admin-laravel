<?php

namespace App\Filament\Resources\ServiceCenterContracts\Pages;

use App\Filament\Resources\ServiceCenterContracts\ServiceCenterContractResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceCenterContract extends CreateRecord
{
    protected static string $resource = ServiceCenterContractResource::class;
}
