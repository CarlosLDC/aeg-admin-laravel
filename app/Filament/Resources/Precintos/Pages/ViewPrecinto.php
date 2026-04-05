<?php

namespace App\Filament\Resources\Precintos\Pages;

use App\Filament\Resources\Precintos\PrecintoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrecinto extends ViewRecord
{
    protected static string $resource = PrecintoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
