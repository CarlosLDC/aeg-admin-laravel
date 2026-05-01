<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TaxpayerType: string implements HasColor, HasIcon, HasLabel
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

    public function getColor(): ?string
    {
        return match ($this) {
            self::Ordinary => 'info',
            self::Special => 'warning',
            self::Formal => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Ordinary => 'heroicon-m-building-storefront',
            self::Special => 'heroicon-m-building-office-2',
            self::Formal => 'heroicon-m-document-text',
        };
    }
}
