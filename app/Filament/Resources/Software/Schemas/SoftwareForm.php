<?php

namespace App\Filament\Resources\Software\Schemas;

use App\Filament\Schemas\SoftwareSchemas;
use App\Filament\Support\SearchPromptText;
use App\Models\SoftwareProvider;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('software_provider_id')
                    ->label('Casa de Software')
                    ->required()
                    ->relationship('softwareProvider', 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (SoftwareProvider $softwareProvider) => $softwareProvider->branch->trade_name
                    )
                    ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId()),
                ...SoftwareSchemas::form(),
            ]);
    }
}
