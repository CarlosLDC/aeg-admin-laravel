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
                TextEntry::make('distributor.id')
                    ->label('Distributor'),
                TextEntry::make('purchase_date')
                    ->date(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('discount')
                    ->numeric(),
                TextEntry::make('tax')
                    ->numeric(),
                TextEntry::make('total')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('payment_term')
                    ->badge(),
                TextEntry::make('payment_status')
                    ->badge(),
                TextEntry::make('due_date')
                    ->date()
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
