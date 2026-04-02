<?php

namespace App\Filament\Resources\Representatives\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RepresentativeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('national_id')
                    ->label('Cédula'),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora'),
                TextEntry::make('phone')
                    ->label('Teléfono'),
                TextEntry::make('email')
                    ->label('Correo Electrónico'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
