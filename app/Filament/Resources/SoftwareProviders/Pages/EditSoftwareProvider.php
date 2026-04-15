<?php

namespace App\Filament\Resources\SoftwareProviders\Pages;

use App\Filament\Resources\SoftwareProviders\SoftwareProviderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSoftwareProvider extends EditRecord
{
    protected static string $resource = SoftwareProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
