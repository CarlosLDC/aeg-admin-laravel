<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Enums\PaymentTerm;
use App\Models\Distributor;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakePurchaseDate = fake()->dateTimeThisDecade();

        $fakePaymentTerm = fake()->randomElement(PaymentTerm::cases());

        $fakeDueDate = $fakePaymentTerm === PaymentTerm::Credit
            ? fake()->dateTimeBetween($fakePurchaseDate, '+1 year')
            : null;

        return [
            'distributor_id' => Distributor::factory(),
            'purchase_date' => $fakePurchaseDate->format('Y-m-d'),
            'subtotal' => fake()->randomFloat(2, min: 100, max: 1000),
            'discount' => fake()->randomFloat(2, min: 0, max: 100),
            'tax' => fake()->randomFloat(2, min: 10, max: 100),
            'payment_term' => $fakePaymentTerm,
            'due_date' => $fakeDueDate?->format('Y-m-d'),
            'payment_status' => fake()->randomElement(PaymentStatus::cases()),
        ];
    }
}
