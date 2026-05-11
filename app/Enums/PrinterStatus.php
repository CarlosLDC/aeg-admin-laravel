<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PrinterStatus: string implements HasColor, HasIcon, HasLabel
{
    case Testing = 'laboratorio';
    case Warehouse = 'almacen';
    case Installed = 'instalada';
    case Maintenance = 'mantenimiento';
    case Retired = 'desincorporada';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Testing => 'Laboratorio',
            self::Warehouse => 'Almacén',
            self::Installed => 'Instalada',
            self::Maintenance => 'Mantenimiento',
            self::Retired => 'Desincorporada',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Testing => 'danger',
            self::Warehouse => 'info',
            self::Installed => 'success',
            self::Maintenance => 'warning',
            self::Retired => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Testing => 'heroicon-m-beaker',
            self::Warehouse => 'heroicon-m-archive-box',
            self::Installed => 'heroicon-m-check-circle',
            self::Maintenance => 'heroicon-m-wrench',
            self::Retired => 'heroicon-m-x-circle',
        };
    }
}
