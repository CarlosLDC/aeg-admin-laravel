<?php

namespace Database\Factories;

use App\Models\distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<distributor>
 */
class DistributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => fake()->numberBetween(1, 50),
        ];
    }
}
