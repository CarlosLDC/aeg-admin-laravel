<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...BranchSpecializationSchemas::infolist(),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->placeholder('-'),
                TextEntry::make('distributor.branch.company.tax_id')
                    ->label('RIF de la Distribuidora')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
