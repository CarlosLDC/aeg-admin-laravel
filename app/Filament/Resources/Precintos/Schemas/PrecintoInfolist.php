<?php

namespace App\Filament\Resources\Precintos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PrecintoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('impresora.serial_fiscal')
                    ->label('Impresora'),
                TextEntry::make('serial')
                    ->label('Serial'),
                TextEntry::make('color')
                    ->label('Color'),
                TextEntry::make('estatus')
                    ->label('Estatus'),
                TextEntry::make('fecha_instalacion')
                    ->label('Fecha de Instalación')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('fecha_retiro')
                    ->label('Fecha de Retiro')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
