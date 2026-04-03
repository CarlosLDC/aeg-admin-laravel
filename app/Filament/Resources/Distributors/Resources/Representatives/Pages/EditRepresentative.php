<?php

namespace App\Filament\Resources\Distributors\Resources\Representatives\Pages;

use App\Filament\Resources\Distributors\Resources\Representatives\RepresentativeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRepresentative extends EditRecord
{
    protected static string $resource = RepresentativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
