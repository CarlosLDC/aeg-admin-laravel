<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BranchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trade_name')
                    ->label('Nombre comercial'),
                TextEntry::make('company.tax_id')
                    ->label('RIF'),
                TextEntry::make('state')
                    ->label('Estado'),
                TextEntry::make('city')
                    ->label('Ciudad'),
                TextEntry::make('address')
                    ->label('Dirección'),
                TextEntry::make('phone')
                    ->label('Teléfono'),
                TextEntry::make('email')
                    ->label('Correo electrónico'),
                TextEntry::make('contact_person')
                    ->label('Persona de contacto'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
