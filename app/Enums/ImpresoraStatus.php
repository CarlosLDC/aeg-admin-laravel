<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ImpresoraStatus: string implements HasLabel
{
    case Laboratorio = 'laboratorio';
    case Instalada = 'instalada';
    case Mantenimiento = 'mantenimiento';
    case Retirada = 'retirada';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Laboratorio => 'Laboratorio',
            self::Instalada => 'Instalada',
            self::Mantenimiento => 'Mantenimiento',
            self::Retirada => 'Retirada',
        };
    }
}
