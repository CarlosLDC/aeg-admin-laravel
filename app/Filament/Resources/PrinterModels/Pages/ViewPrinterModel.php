<?php

namespace App\Filament\Resources\PrinterModels\Pages;

use App\Filament\Resources\PrinterModels\PrinterModelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrinterModel extends ViewRecord
{
    protected static string $resource = PrinterModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
