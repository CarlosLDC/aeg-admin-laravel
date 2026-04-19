<?php

namespace App\Filament\Resources\Precints\Pages;

use App\Filament\Resources\Precints\PrecintResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrecint extends ViewRecord
{
    protected static string $resource = PrecintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
