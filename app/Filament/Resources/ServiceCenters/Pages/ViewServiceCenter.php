<?php

namespace App\Filament\Resources\ServiceCenters\Pages;

use App\Filament\Resources\ServiceCenters\ServiceCenterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCenter extends ViewRecord
{
    protected static string $resource = ServiceCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
