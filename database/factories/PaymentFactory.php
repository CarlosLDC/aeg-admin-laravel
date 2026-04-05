<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethod = fake()->randomElement(PaymentMethod::cases());

        $currency = match ($paymentMethod) {
            PaymentMethod::CashUsd,
            PaymentMethod::Zelle => 'USD',
            default => 'VES',
        };

        $amount = fake()->randomFloat(2, 5, 500);
        $igtfRate = $currency === 'USD' ? 0.03 : 0;
        $igtfAmount = round($amount * $igtfRate, 2);

        $referencePattern = match ($paymentMethod) {
            PaymentMethod::Mobile => 'PM-##########',
            PaymentMethod::Debit => 'PV-########',
            PaymentMethod::Transfer => 'TR-################',
            PaymentMethod::Zelle => 'ZE-############',
            PaymentMethod::CashUsd => 'USD-########',
            PaymentMethod::CashBs => 'VES-########',
        };

        return [
            'purchase_id' => Purchase::factory(),
            'amount' => $amount,
            'currency' => $currency,
            'exchange_rate' => $currency === 'USD' ? fake()->randomFloat(4, 35, 100) : 1,
            'igtf_rate' => $igtfRate,
            'igtf_amount' => $igtfAmount,
            'total_amount' => round($amount + $igtfAmount, 2),
            'payment_method' => $paymentMethod,
            'reference_number' => fake()->unique()->bothify($referencePattern),
            'paid_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
