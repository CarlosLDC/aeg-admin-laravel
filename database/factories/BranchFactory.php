<?php

namespace Database\Factories;

use App\Enums\VenezuelaState;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => fake()->numberBetween(1, 10),
            'trade_name' => fake()->company(),
            'state' => fake()->randomElement(VenezuelaState::cases()),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->freeEmail(),
        ];
    }
}
