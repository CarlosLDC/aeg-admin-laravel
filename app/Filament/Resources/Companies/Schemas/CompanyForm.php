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
                    ->label('Razón Social')
                    ->required(),
                TextInput::make('tax_id')
                    ->label('RIF')
                    ->placeholder('J123456789')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'El RIF debe comenzar con V, E, J, P o G (en mayúsculas) seguido de 9 dígitos, sin separadores ni espacios. Si tiene menos de 9 dígitos, complete con ceros a la izquierda. Ejemplo: J012345678.')
                    ->required()
                    ->regex('/^[VEJPG][0-9]{9}$/')
                    ->validationMessages([
                        'regex' => 'Formato de RIF inválido.',
                    ]),
                Select::make('taxpayer_type')
                    ->label('Tipo de Contribuyente')
                    ->required()
                    ->options(TaxpayerType::class)
                    ->default('ordinario')
            ]);
    }
}
