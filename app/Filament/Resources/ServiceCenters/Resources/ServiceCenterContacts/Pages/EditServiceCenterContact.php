<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Pages;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\ServiceCenterContactResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServiceCenterContact extends EditRecord
{
    protected static string $resource = ServiceCenterContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
