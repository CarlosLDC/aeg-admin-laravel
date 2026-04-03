<?php

namespace App\Filament\Resources\Distributors\Resources\Representatives\Pages;

use App\Filament\Resources\Distributors\Resources\Representatives\RepresentativeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRepresentative extends ViewRecord
{
    protected static string $resource = RepresentativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
