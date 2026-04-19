<?php

namespace App\Filament\Resources\SoftwareProviders\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use Filament\Schemas\Schema;

class SoftwareProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...BranchSpecializationSchemas::form(),
            ]);
    }
}
