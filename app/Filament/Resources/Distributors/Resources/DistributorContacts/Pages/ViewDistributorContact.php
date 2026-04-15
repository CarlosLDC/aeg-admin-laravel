<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContacts\Pages;

use App\Filament\Resources\Distributors\Resources\DistributorContacts\DistributorContactResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDistributorContact extends ViewRecord
{
    protected static string $resource = DistributorContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
