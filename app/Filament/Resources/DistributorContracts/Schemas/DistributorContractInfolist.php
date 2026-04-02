<?php

namespace App\Filament\Resources\DistributorContracts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;

class DistributorContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('distributor.branch.trade_name')
                    ->label('Distribuidor'),
                TextEntry::make('distributor.branch.company.tax_id')
                    ->label('RIF del distribuidor'),
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
