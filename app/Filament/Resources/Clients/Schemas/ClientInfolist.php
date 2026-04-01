<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('branch.trade_name')
                    ->label('Sucursal'),
                TextEntry::make('branch.company.tax_id')
                    ->label('RIF de la Sucursal'),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidor')
                    ->placeholder('-'),
                TextEntry::make('distributor.branch.company.tax_id')
                    ->label('RIF del Distribuidor')
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
