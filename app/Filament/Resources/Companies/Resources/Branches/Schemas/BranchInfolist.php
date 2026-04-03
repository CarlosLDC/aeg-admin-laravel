<?php

namespace App\Filament\Resources\Companies\Resources\Branches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BranchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trade_name')
                    ->label('Nombre Comercial'),
                TextEntry::make('state')
                    ->badge(),
                TextEntry::make('city')
                    ->label('Ciudad'),
                TextEntry::make('address')
                    ->label('Dirección')
                    ->columnSpanFull(),
                TextEntry::make('phone')
                    ->label('Número de Teléfono'),
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
