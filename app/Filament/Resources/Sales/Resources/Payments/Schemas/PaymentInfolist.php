<?php

namespace App\Filament\Resources\Sales\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('payment_method')
                    ->label('Método de Pago'),
                TextEntry::make('currency')
                    ->label('Moneda'),
                TextEntry::make('exchange_rate')
                    ->label('Tasa BCV')
                    ->numeric(),
                TextEntry::make('amount')
                    ->label('Monto Base')
                    ->money(),
                TextEntry::make('igtf_rate')
                    ->label('Tasa IGTF')
                    ->numeric(),
                TextEntry::make('igtf_amount')
                    ->label('Monto IGTF')
                    ->money(),
                TextEntry::make('total_amount')
                    ->label('Monto Total')
                    ->money(),
                TextEntry::make('reference_number')
                    ->label('Referencia'),
                TextEntry::make('paid_at')
                    ->label('Fecha y Hora de Pago')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
