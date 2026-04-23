<?php

namespace App\Filament\Resources\PrinterModels\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PrinterModelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('brand')
                    ->label('Marca'),
                TextEntry::make('model')
                    ->label('Modelo'),
                TextEntry::make('device_type')
                    ->label('Tipo de Dispositivo'),
                TextEntry::make('price')
                    ->label('Precio')
                    ->money(),
                TextEntry::make('administrative_act')
                    ->label('Providencia'),
                TextEntry::make('certification_date')
                    ->label('Fecha de Homologación')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
