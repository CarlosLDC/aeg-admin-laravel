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
                // TextEntry::make('branch_id')
                //     ->numeric(),
                // TextEntry::make('distributor_id')
                //     ->numeric(),
                TextEntry::make('branch.trade_name')
                    ->label('Sucursal'),
                TextEntry::make('branch.company.tax_id')
                    ->label('RIF de la sucursal'),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidor'),
                TextEntry::make('distributor.branch.company.tax_id')
                    ->label('RIF del distribuidor'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
