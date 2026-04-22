<?php

namespace App\Filament\Resources\Printers\Schemas;

use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PrinterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('fiscal_serial_number')
                    ->label('Serial Fiscal'),
                TextEntry::make('model')
                    ->label('Modelo'),
                TextEntry::make('mac_address')
                    ->label('Dirección MAC')
                    ->placeholder('-'),
                TextEntry::make('firmware.version')
                    ->label('Versión de Firmware')
                    ->placeholder('-'),
                TextEntry::make('software.full_name')
                    ->label('Software')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Estatus')
                    ->placeholder('-'),
                TextEntry::make('client.id')
                    ->label('ID de Cliente')
                    ->placeholder('-'),
                TextEntry::make('installation_date')
                    ->label('Fecha de Instalación')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('sale.invoice_number')
                    ->label('Número de Factura')
                    ->placeholder('-'),
                TextEntry::make('final_sale_price')
                    ->label('Precio de Venta Final')
                    ->money()
                    ->placeholder('-'),                
                TextEntry::make('is_paid')
                    ->label('¿Pagada?')
                    ->boolean()
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
