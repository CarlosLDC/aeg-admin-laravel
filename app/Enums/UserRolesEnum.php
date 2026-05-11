<?php

namespace App\Enums;

enum UserRolesEnum: string
{
    case Admin = 'admin';
    case Distributor = 'distribuidor';
    case ServiceCenter = 'centro_servicio';
    case Client = 'cliente';
}
