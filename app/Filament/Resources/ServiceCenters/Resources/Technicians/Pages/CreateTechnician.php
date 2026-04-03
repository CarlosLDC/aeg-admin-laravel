<?php

namespace App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages;

use App\Filament\Resources\ServiceCenters\Resources\Technicians\TechnicianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnician extends CreateRecord
{
    protected static string $resource = TechnicianResource::class;
}
