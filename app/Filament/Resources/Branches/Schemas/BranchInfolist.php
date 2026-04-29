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
                TextEntry::make('company.id')
                    ->label('Company'),
                TextEntry::make('trade_name'),
                TextEntry::make('state')
                    ->badge(),
                TextEntry::make('city'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('phone_primary'),
                TextEntry::make('phone_secondary')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('contact_person'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
