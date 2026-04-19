<?php

namespace App\Filament\Resources\Distributors\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DistributorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...BranchSpecializationSchemas::infolist(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
