<?php

namespace App\Filament\Resources\Firmware\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FirmwareInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('version')
                    ->label('Versión'),
                TextEntry::make('release_date')
                    ->label('Fecha de lanzamiento')
                    ->date(),
                TextEntry::make('description')
                    ->label('Descripción')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
