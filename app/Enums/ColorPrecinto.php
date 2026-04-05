<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ColorPrecinto: string implements HasLabel
{
    case Blanco = 'blanco';
    case Amarillo = 'amarillo';
    case Azul = 'azul';
    case Rojo = 'rojo';
    case Verde = 'verde';
    case Negro = 'negro';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Blanco => 'Blanco',
            self::Amarillo => 'Amarillo',
            self::Azul => 'Azul',
            self::Rojo => 'Rojo',
            self::Verde => 'Verde',
            self::Negro => 'Negro',
        };
    }
}
