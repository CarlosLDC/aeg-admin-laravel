<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Pages;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\ServiceCenterContactResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCenterContact extends ViewRecord
{
    protected static string $resource = ServiceCenterContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
