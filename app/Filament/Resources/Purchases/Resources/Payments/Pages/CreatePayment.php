<?php

namespace App\Filament\Resources\Purchases\Resources\Payments\Pages;

use App\Filament\Resources\Purchases\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getRedirectUrl(): string
    {
        return url()->previous();
    }
}
