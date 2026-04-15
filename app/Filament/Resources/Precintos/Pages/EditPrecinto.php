<?php

namespace App\Filament\Resources\Precintos\Pages;

use App\Filament\Resources\Precintos\PrecintoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPrecinto extends EditRecord
{
    protected static string $resource = PrecintoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
