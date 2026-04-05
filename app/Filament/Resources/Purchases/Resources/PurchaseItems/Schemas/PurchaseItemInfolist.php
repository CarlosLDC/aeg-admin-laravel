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
                TextEntry::make('printerModel.name')
                    ->label('Impresora'),
                TextEntry::make('unit_price')
                    ->label('Precio Unitario')
                    ->money(),
                TextEntry::make('quantity')
                    ->label('Cantidad')
                    ->numeric(),
                TextEntry::make('discount')
                    ->label('Descuento')
                    ->money(),
                TextEntry::make('tax.name')
                    ->label('Alícuota'),
                TextEntry::make('applied_tax_rate')
                    ->label('Alícuota Aplicada')
                    ->numeric(),
                TextEntry::make('line_total')
                    ->label('Subtotal')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('tax_amount')
                    ->label('Importe del Impuesto')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('grand_total')
                    ->label('Total')
                    ->money()
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
