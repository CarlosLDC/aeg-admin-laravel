<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TaxpayerType: string implements HasLabel
{
    case Ordinary = 'ordinario';
    case Special = 'especial';
    case Formal = 'formal';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ordinary => 'Ordinario',
            self::Special => 'Especial',
            self::Formal => 'Formal',
        };
    }
}
