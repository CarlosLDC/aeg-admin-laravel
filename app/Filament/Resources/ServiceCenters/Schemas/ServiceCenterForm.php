<?php

namespace App\Filament\Resources\ServiceCenters\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use Filament\Schemas\Schema;

class ServiceCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...BranchSpecializationSchemas::form(),
            ]);
    }
}
