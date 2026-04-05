<?php

namespace App\Filament\Resources\Precintos\Pages;

use App\Filament\Resources\Precintos\PrecintoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrecintos extends ListRecords
{
    protected static string $resource = PrecintoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
