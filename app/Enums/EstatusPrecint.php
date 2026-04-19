<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EstatusPrecint: string implements HasLabel
{
    case Disponible = 'disponible';
    case Instalado = 'instalado';
    case Retirado = 'retirado';
    case Anulado = 'anulado';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Disponible => 'Disponible',
            self::Instalado => 'Instalado',
            self::Retirado => 'Retirado',
            self::Anulado => 'Anulado',
        };
    }
}
