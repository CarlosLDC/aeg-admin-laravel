<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BranchRoles: string implements HasLabel
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
            self::SoftwareProvider => 'Proveedor de Software',
            self::Client => 'Cliente',
        };
    }
}
