<?php

namespace App\Filament\Resources\Purchases\Resources\Payments\Schemas;

use App\Enums\PaymentMethod;
use App\Models\Payment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        $recalculateTotals = function (Get $get, Set $set): void {
            $payment = new Payment([
                'amount' => (float) max(0, ($get('amount') ?? 0)),
                'currency' => (string) ($get('currency') ?? 'VES'),
                'igtf_rate' => (float) max(0, ($get('igtf_rate') ?? 0)),
            ]);

            $payment->recalculateTotals();

            $set('igtf_rate', (float) $payment->igtf_rate);
            $set('igtf_amount', round((float) $payment->igtf_amount, 2));
            $set('total_amount', round((float) $payment->total_amount, 2));
        };

        return $schema
            ->components([
                Select::make('payment_method')
                    ->label('Método de Pago')
                    ->required()
                    ->options(PaymentMethod::class),
                Select::make('currency')
                    ->label('Moneda')
                    ->required()
                    ->options([
                        'VES' => 'Bolívares (VES)',
                        'USD' => 'Dólares (USD)',
                    ])
                    ->default('VES')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) use ($recalculateTotals): void {
                        if ($get('currency') === 'VES') {
                            $set('exchange_rate', 1);
                            $set('igtf_rate', 0);
                        } elseif ((float) ($get('igtf_rate') ?? 0) === 0.0) {
                            $set('igtf_rate', 0.03);
                        }

                        $recalculateTotals($get, $set);
                    }),
                TextInput::make('exchange_rate')
                    ->label('Tasa BCV')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->step(0.0001)
                    ->disabled(fn (Get $get): bool => $get('currency') === 'VES'),
                TextInput::make('amount')
                    ->label('Monto Base')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('$')
                    ->live(debounce: 500)
                    ->afterStateUpdated($recalculateTotals),
                TextInput::make('igtf_rate')
                    ->label('Tasa IGTF')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1)
                    ->step(0.0001)
                    ->default(0)
                    ->disabled(fn (Get $get): bool => $get('currency') === 'VES')
                    ->live(debounce: 500)
                    ->afterStateUpdated($recalculateTotals),
                TextInput::make('reference_number')
                    ->label('Referencia')
                    ->required()
                    ->unique(ignoreRecord: true),
                DateTimePicker::make('paid_at')
                    ->label('Fecha y Hora de Pago')
                    ->seconds(false)
                    ->native(false)
                    ->default(now())
                    ->required(),
                Fieldset::make('Totales')
                    ->schema([
                        TextInput::make('igtf_amount')
                            ->label('Monto IGTF')
                            ->prefix('$')
                            ->default(0)
                            ->readOnly()
                            ->dehydrated(false),
                        TextInput::make('total_amount')
                            ->label('Monto Total')
                            ->prefix('$')
                            ->default(0)
                            ->readOnly()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
