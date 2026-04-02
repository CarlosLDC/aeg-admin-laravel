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
        return [
            'distributor_id' => Distributor::factory(),
            'purchase_date' => fake()->date(),
            'subtotal' => fake()->randomFloat(2, min: 100, max: 1000),
            'discount' => fake()->randomFloat(2, min: 0, max: 100),
            'tax' => fake()->randomFloat(2, min: 10, max: 100),
            'payment_term' => fake()->randomElement(PaymentTerm::cases()),
            'payment_status' => fake()->randomElement(PaymentStatus::cases()),
            'due_date' => fake()->optional()->dateTimeThisDecade()?->format('Y-m-d'),
        ];
    }
}
