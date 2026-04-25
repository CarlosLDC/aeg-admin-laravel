<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRolesEnum: string implements HasColor, HasLabel
{
    case Admin = 'admin';
    case Distributor = 'distribuidor';
    case ServiceCenter = 'centro_servicio';
    case Client = 'cliente';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Distributor => 'Distribuidor',
            self::ServiceCenter => 'Centro de Servicio',
            self::Client => 'Cliente',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Admin => 'danger',
            self::Distributor => 'success',
            self::ServiceCenter => 'warning',
            self::Client => 'gray',
        };
    }
}
