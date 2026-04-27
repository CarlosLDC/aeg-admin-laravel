<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoice_number')
                    ->label('Número de Factura'),
                TextEntry::make('sale_date')
                    ->label('Fecha de Venta')
                    ->date(),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora'),
                TextEntry::make('total')
                    ->label('Total')
                    ->numeric()
                    ->prefix('$'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
