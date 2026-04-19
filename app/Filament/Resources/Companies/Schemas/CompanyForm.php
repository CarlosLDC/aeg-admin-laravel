<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Enums\TaxpayerType;
use App\Filament\Support\HintIconText;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tax_id')
                    ->label('RIF')
                    ->required()
                    ->regex('/^[VEJPG][0-9]{9}$/')
                    ->placeholder('J123456789')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: HintIconText::rif()),
                TextInput::make('legal_name')
                    ->label('Razón Social')
                    ->required(),
                Select::make('taxpayer_type')
                    ->label('Tipo de Contribuyente')
                    ->required()
                    ->options(TaxpayerType::class)
                    ->default('ordinario')
                    ->native(false),
            ]);
    }
}
