<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Enums\TaxpayerType;
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
                    ->regex('/^[vejgcpVEJGCP]-?\d{8}-?\d$/'),
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
