<?php

namespace App\Filament\Resources\Sales\Resources\Payments\Pages;

use App\Filament\Resources\Sales\Resources\Payments\PaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getRedirectUrl(): string
    {
        return url()->previous();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successRedirectUrl(fn (): string => url()->previous()),
        ];
    }
}
