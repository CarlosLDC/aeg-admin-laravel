<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DeviceType: string implements HasLabel
{
    case Internal = 'interno';
    case External = 'externo';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Internal => 'Interno',
            self::External => 'Externo',
        };
    }
}
