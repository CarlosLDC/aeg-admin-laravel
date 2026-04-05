<?php

namespace App\Filament\Resources\Impresoras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ImpresoraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('printerModel.name')
                    ->label('Modelo de Impresora'),
                TextEntry::make('serial_fiscal')
                    ->label('Serial Fiscal'),
                TextEntry::make('precio_venta_final')
                    ->label('Precio de Venta Final')
                    ->money(),
                TextEntry::make('estatus')
                    ->label('Estatus'),
                TextEntry::make('tipo_dispositivo')
                    ->label('Tipo de Dispositivo'),
                TextEntry::make('software.name')
                    ->label('Software'),
                TextEntry::make('purchase.invoice_number')
                    ->label('Compra'),
                TextEntry::make('branch.trade_name')
                    ->label('Sucursal'),
                TextEntry::make('firmware.version')
                    ->label('Firmware'),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora'),
                    TextEntry::make('se_pago')
                        ->label('Se Pagó')
                        ->badge()
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Sí' : 'No')
                        ->color(fn (string $state): string => $state === 'Sí' ? 'success' : 'gray'),
                TextEntry::make('fecha_instalacion')
                    ->label('Fecha de Instalación')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('version_firmware')
                    ->label('Versión de Firmware')
                    ->placeholder('-'),
                TextEntry::make('direccion_mac')
                    ->label('Dirección MAC')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}