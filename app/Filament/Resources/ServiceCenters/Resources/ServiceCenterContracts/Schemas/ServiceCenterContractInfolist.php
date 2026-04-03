<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceCenterContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('start_date')
                    ->label('Fecha de Inicio')
                    ->date(),
                TextEntry::make('end_date')
                    ->label('Fecha de Finalización')
                    ->date(),
                TextEntry::make('photo_path')
                    ->label('Ruta de la Foto del Contrato')
                    ->copyable()
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
