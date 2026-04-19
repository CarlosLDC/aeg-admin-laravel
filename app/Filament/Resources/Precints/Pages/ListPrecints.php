<?php

namespace App\Filament\Resources\Precints\Pages;

use App\Filament\Resources\Precints\PrecintResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrecints extends ListRecords
{
    protected static string $resource = PrecintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
