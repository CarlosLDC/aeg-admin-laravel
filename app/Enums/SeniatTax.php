<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SeniatTax: string implements HasLabel
{
    case General = '16';
    case Reduced = '8';
    case Additional = '31';
    case Exempt = '0';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::General => 'General (16%)',
            self::Reduced => 'Reducido (8%)',
            self::Additional => 'Lujo (31%)',
            self::Exempt => 'Exento (0%)',
        };
    }

    public function getRate(): float
    {
        return (float) $this->value / 100;
    }
}