<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BranchRoles: string implements HasColor, HasIcon, HasLabel
{
    case Distributor = 'distributor';
    case ServiceCenter = 'service_center';
    case SoftwareProvider = 'software_provider';
    case Client = 'client';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Distributor => 'Distribuidora',
            self::ServiceCenter => 'Centro de Servicio',
            self::SoftwareProvider => 'Casa de Software',
            self::Client => 'Cliente',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Distributor => 'success',
            self::ServiceCenter => 'warning',
            self::SoftwareProvider => 'info',
            self::Client => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Distributor => 'heroicon-m-truck',
            self::ServiceCenter => 'heroicon-m-wrench-screwdriver',
            self::SoftwareProvider => 'heroicon-m-computer-desktop',
            self::Client => 'heroicon-m-building-storefront',
        };
    }
}
