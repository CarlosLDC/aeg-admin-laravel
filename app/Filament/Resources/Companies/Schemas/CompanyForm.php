<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Enums\TaxpayerType;
use App\Filament\Support\HintIconText;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('tax_id')
                                    ->label('RIF')
                                    ->required()
                                    ->unique()
                                    ->regex('/^[VEJGCP][0-9]{1,9}$/i')
                                    ->stripCharacters('-')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: HintIconText::taxId())
                                    ->placeholder('J123456789'),
                                TextInput::make('legal_name')
                                    ->label('Razón Social')
                                    ->required()
                                    ->placeholder('Alpha Engineer Group, C.A.'),
                                Select::make('taxpayer_type')
                                    ->label('Tipo de Contribuyente')
                                    ->required()
                                    ->options(TaxpayerType::class)
                                    ->default('ordinario'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
