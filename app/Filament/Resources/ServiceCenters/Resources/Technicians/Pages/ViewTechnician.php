<?php

namespace App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages;

use App\Filament\Resources\ServiceCenters\Resources\Technicians\TechnicianResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTechnician extends ViewRecord
{
    protected static string $resource = TechnicianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
