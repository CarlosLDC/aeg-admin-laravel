<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContracts\Pages;

use App\Filament\Resources\Distributors\Resources\DistributorContracts\DistributorContractResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDistributorContract extends EditRecord
{
    protected static string $resource = DistributorContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
