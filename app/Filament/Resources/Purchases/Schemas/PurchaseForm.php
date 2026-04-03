<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Enums\PaymentStatus;
use App\Enums\PaymentTerm;
use App\Enums\SeniatTax;
use App\Filament\Support\DistributorSelect;
use Faker\Provider\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('distributor_id')
                    ->label('Distribuidora')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                    ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                DatePicker::make('purchase_date')
                    ->label('Fecha de Compra')
                    ->required(),
                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->gt(0)
                    ->validationMessages([
                        'gt' => 'El subtotal debe ser mayor que cero.',
                    ]),
                TextInput::make('discount')
                    ->label('Descuento')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0)
                    ->gte(0)
                    ->validationMessages([
                        'gte' => 'El descuento no puede ser negativo.',
                    ]),
                TextInput::make('tax')
                    ->label('Monto del Impuesto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->gte(0)
                    ->validationMessages([
                        'gte' => 'El monto del impuesto no puede ser negativo.',
                    ]),
                Select::make('payment_term')
                    ->label('Tipo de Pago')
                    ->options(PaymentTerm::class)
                    ->required()
                    ->live(),
                DatePicker::make('due_date')
                    ->label('Fecha Tope de Pago')
                    ->visible(fn(Get $get): bool => $get('payment_term') === PaymentTerm::Credit)
                    ->required()
                    ->after('purchase_date')
                    ->validationMessages([
                        'after' => 'La fecha tope de pago debe ser posterior a la fecha de compra.',
                    ]),
                Select::make('payment_status')
                    ->label('Estado de Pago')
                    ->options(PaymentStatus::class)
                    ->default(PaymentStatus::Pending->value)
                    ->required(),
            ]);
    }
}
