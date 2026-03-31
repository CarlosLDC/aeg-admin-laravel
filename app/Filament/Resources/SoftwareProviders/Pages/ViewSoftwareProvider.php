<?php

namespace App\Filament\Resources\SoftwareProviders\Pages;

use App\Filament\Resources\SoftwareProviders\SoftwareProviderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSoftwareProvider extends ViewRecord
{
    protected static string $resource = SoftwareProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
