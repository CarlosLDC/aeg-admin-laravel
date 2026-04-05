<?php

namespace App\Filament\Resources\Impresoras\Pages;

use App\Filament\Resources\Impresoras\ImpresoraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImpresora extends ViewRecord
{
    protected static string $resource = ImpresoraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
