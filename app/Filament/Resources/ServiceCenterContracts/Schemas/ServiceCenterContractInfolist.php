<?php

namespace App\Filament\Resources\ServiceCenterContracts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;

class ServiceCenterContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('serviceCenter.branch.trade_name')
                    ->label('Centro de Servicio'),
                TextEntry::make('serviceCenter.branch.company.tax_id')
                    ->label('RIF del Centro de Servicio'),
                TextEntry::make('start_date')
                    ->label('Fecha de inicio')
                    ->date(),
                TextEntry::make('end_date')
                    ->label('Fecha de finalización')
                    ->date(),
                TextEntry::make('photo_path')
                    ->label('Ruta de la foto del contrato')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->iconPosition(IconPosition::After)
                    ->columnSpanFull()
                    ->copyable(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
