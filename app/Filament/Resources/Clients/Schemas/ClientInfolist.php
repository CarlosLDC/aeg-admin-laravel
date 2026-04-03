<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('branch.trade_name')
                    ->label('Sucursal'),
                TextEntry::make('branch.company.tax_id')
                    ->label('RIF'),
                TextEntry::make('branch.state')
                    ->label('Estado'),
                TextEntry::make('branch.city')
                    ->label('Ciudad'),
                TextEntry::make('branch.phone')
                    ->label('Teléfono'),
                TextEntry::make('branch.email')
                    ->label('Correo Electrónico'),
                TextEntry::make('branch.contact_person')
                    ->label('Persona de Contacto'),
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->placeholder('-'),
                TextEntry::make('distributor.branch.company.tax_id')
                    ->label('RIF de la Distribuidora')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
