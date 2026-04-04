<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PurchaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora'),
                TextEntry::make('invoice_number')
                    ->label('Número de Factura'),
                TextEntry::make('purchase_date')
                    ->label('Fecha de Compra')
                    ->date(),
                TextEntry::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('$'),
                TextEntry::make('global_discount')
                    ->label('Descuento Global')
                    ->numeric()
                    ->prefix('$'),
                TextEntry::make('total_tax')
                    ->label('Impuesto Total')
                    ->numeric()
                    ->prefix('$'),
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
