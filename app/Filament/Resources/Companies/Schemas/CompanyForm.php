<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Enums\TaxpayerType;
use App\Filament\Support\HintIconText;
use App\Models\Company;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Fiscal de las Empresas')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('tax_id')
                                    ->label('RIF')
                                    ->required()
                                    ->unique()
                                    ->regex('/^[VEJGCP][0-9]{1,9}$/i')
                                    ->stripCharacters('-')
                                    ->hintIcon(
                                        icon: 'heroicon-m-question-mark-circle',
                                        tooltip: HintIconText::taxId()
                                    )
                                    ->placeholder('J123456789')
                                    ->disabled(
                                        fn(?Company $record) => $record?->branches()->exists()
                                    ),
                                TextInput::make('legal_name')
                                    ->label('Razón Social')
                                    ->required()
                                    ->unique()
                                    ->placeholder('Empresa S.A. de C.V.'),
                                ToggleButtons::make('taxpayer_type')
                                    ->label('Tipo de Contribuyente')
                                    ->required()
                                    ->inline()
                                    ->options(TaxpayerType::class)
                                    ->default(TaxpayerType::Ordinary->value),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
