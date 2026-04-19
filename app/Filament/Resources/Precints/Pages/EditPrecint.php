<?php

namespace App\Filament\Resources\Precints\Pages;

use App\Filament\Resources\Precints\PrecintResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPrecint extends EditRecord
{
    protected static string $resource = PrecintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
