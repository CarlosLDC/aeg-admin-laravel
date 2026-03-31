<?php

namespace App\Filament\Resources\Firmware\Pages;

use App\Filament\Resources\Firmware\FirmwareResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFirmware extends ViewRecord
{
    protected static string $resource = FirmwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
