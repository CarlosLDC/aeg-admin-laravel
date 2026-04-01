<?php

namespace App\Filament\Resources\SoftwareProviders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SoftwareProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('tax_id')
                    ->label('RIF'),
                TextEntry::make('phone')
                    ->label('Teléfono'),
                TextEntry::make('email')
                    ->label('Correo Electrónico'),
                TextEntry::make('contact_person')
                    ->label('Persona de Contacto'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
