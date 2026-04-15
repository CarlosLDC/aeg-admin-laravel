<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PrinterStatus: string implements HasLabel
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
}
