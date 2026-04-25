<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PrinterStatus: string implements HasColor, HasLabel
{
    case Testing = 'laboratorio';
    case Installed = 'instalada';
    case Maintenance = 'mantenimiento';
    case Retired = 'retirada';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Testing => 'Laboratorio',
            self::Installed => 'Instalada',
            self::Maintenance => 'Mantenimiento',
            self::Retired => 'Retirada',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Testing => 'info',
            self::Installed => 'success',
            self::Maintenance => 'warning',
            self::Retired => 'gray',
        };
    }
}
