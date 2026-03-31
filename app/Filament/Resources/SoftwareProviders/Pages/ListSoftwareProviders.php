<?php

namespace App\Filament\Resources\SoftwareProviders\Pages;

use App\Filament\Resources\SoftwareProviders\SoftwareProviderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSoftwareProviders extends ListRecords
{
    protected static string $resource = SoftwareProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
