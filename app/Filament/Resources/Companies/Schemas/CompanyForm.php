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
                TextInput::make('legal_name')
                    ->label('Razón social')
                    ->required(),
                TextInput::make('tax_id')
                    ->label('RIF')
                    ->required()
                    ->placeholder('J123456789')
                    ->regex('/^[VEJPG][0-9]{9}$/')
                    ->validationMessages([
                        'regex' => 'El RIF debe comenzar con V, E, J, P o G (en mayúsculas) seguido de 9 dígitos. No separe los dígitos. Si tiene menos de 9 dígitos, complete con ceros a la izquierda (ejemplo: J012345678).',
                    ]),
                Select::make('taxpayer_type')
                    ->label('Tipo de contribuyente')
                    ->required()
                    ->options(TaxpayerType::class)
                    ->default('ordinario')
            ]);
    }
}
