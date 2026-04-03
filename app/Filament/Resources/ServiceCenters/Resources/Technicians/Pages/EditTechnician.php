<?php

namespace App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages;

use App\Filament\Resources\ServiceCenters\Resources\Technicians\TechnicianResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTechnician extends EditRecord
{
    protected static string $resource = TechnicianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
