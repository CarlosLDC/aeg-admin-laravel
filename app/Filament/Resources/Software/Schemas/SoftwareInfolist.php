<?php

namespace App\Filament\Resources\Software\Schemas;

use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SoftwareInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre del Software'),
                TextEntry::make('version')
                    ->label('Versión'),
                TextEntry::make('integration_date')
                    ->label('Fecha de Integración')
                    ->date(),
                TextEntry::make('softwareProvider.name')
                    ->label('Proveedor de Software'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
