<?php

namespace App\Filament\Resources\Printers\Schemas;

use App\Filament\Schemas\PrinterSchemas;
use Filament\Schemas\Schema;

class PrinterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...PrinterSchemas::form(),
            ]);
    }
}
