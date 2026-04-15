<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContacts\Pages;

use App\Filament\Resources\Distributors\Resources\DistributorContacts\DistributorContactResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDistributorContact extends EditRecord
{
    protected static string $resource = DistributorContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
