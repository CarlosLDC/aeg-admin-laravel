<?php

namespace Database\Factories;

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
            'invoice_number' => fake()->unique()->numerify('########'),
            'purchase_date' => fake()->dateTimeThisDecade()->format('Y-m-d'),
            'global_discount' => fake()->numberBetween(0, 20) * 5,
        ];
    }
}
