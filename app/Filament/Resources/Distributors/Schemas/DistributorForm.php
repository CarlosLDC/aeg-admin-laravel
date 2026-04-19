<?php

namespace App\Filament\Resources\Distributors\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use Filament\Schemas\Schema;

class DistributorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...BranchSpecializationSchemas::form(),
            ]);
    }
}
