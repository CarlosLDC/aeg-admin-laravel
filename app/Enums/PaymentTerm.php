<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentTerm: string implements HasLabel
{
    case Immediate = 'immediate';
    case Credit = 'credit';
    case Installments = 'installments';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Immediate => 'Inmediato',
            self::Credit => 'Crédito',
            self::Installments => 'Cuotas',
        };
    }
}
