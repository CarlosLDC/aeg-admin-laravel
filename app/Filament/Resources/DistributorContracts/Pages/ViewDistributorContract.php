<?php

namespace App\Filament\Resources\DistributorContracts\Pages;

use App\Filament\Resources\DistributorContracts\DistributorContractResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDistributorContract extends ViewRecord
{
    protected static string $resource = DistributorContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
