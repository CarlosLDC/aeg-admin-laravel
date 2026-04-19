<?php

namespace App\Filament\Resources\Sales\Resources\Payments\Pages;

use App\Filament\Resources\Sales\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getRedirectUrl(): string
    {
        return url()->previous();
    }
}
