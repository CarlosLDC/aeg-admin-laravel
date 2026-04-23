<?php

namespace App\Filament\Resources\Software\Schemas;

use App\Filament\Schemas\SoftwareSchemas;
use App\Filament\Support\SearchPromptText;
use App\Models\SoftwareProvider;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('software_provider_id')
                    ->label('Proveedor')
                    ->required()
                    ->relationship(
                        name: 'softwareProvider',
                        titleAttribute: 'trade_name',
                        modifyQueryUsing: fn(Builder $query) => $query->withTrashed(),
                    )
                    ->searchable()
                    ->preload()
                    ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId()),
                ...SoftwareSchemas::form(),
            ]);
    }
}
