<?php

namespace App\Filament\Resources\Sales\Resources\SaleItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaleItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('printer.fiscal_serial_number')
                    ->label('Serial Fiscal'),
                TextEntry::make('unit_price')
                    ->label('Precio de Venta Final')
                    ->money(),
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
