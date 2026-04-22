<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PrinterStatus: string implements HasLabel, HasColor
{
    case Testing = 'laboratorio';
    case Installed = 'instalada';
    case Maintenance = 'mantenimiento';
    case Retired = 'retirada';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Testing => 'Laboratorio',
            self::Installed => 'Instalada',
            self::Maintenance => 'Mantenimiento',
            self::Retired => 'Retirada',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Testing => 'info',
            self::Installed => 'success',
            self::Maintenance => 'warning',
            self::Retired => 'gray',
        };
    }
}
