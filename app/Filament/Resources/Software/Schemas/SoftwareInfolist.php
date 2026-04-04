<?php

namespace App\Filament\Resources\Software\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SoftwareInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('version')
                    ->label('Versión'),
                TextEntry::make('integration_date')
                    ->label('Fecha de Integración')
                    ->date(),
                TextEntry::make('operating_systems')
                    ->label('Sistemas Operativos Compatibles'),
                TextEntry::make('programming_languages')
                    ->label('Lenguajes de Programación'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
