<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentTerm: string implements HasLabel
{
    case Immediate = 'immediate';
    case Credit = 'credit';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Immediate => 'Contado',
            self::Credit => 'Crédito',
        };
    }
}
