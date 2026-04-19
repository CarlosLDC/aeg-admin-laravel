<?php

namespace App\Filament\Resources\Sales\Resources\SaleItems\Pages;

use App\Filament\Resources\Sales\Resources\SaleItems\SaleItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSaleItem extends ViewRecord
{
    protected static string $resource = SaleItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
