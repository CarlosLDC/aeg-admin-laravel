<?php

namespace App\Filament\Resources\Purchases\Resources\PurchaseItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PurchaseItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('printerModel.id')
                    ->label('Printer model'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('unit_price')
                    ->money(),
                TextEntry::make('discount')
                    ->numeric(),
                TextEntry::make('tax.name')
                    ->label('Tax'),
                TextEntry::make('applied_tax_rate')
                    ->numeric(),
                TextEntry::make('tax_amount')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('line_total')
                    ->numeric()
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
