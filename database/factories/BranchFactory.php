<?php

namespace Database\Factories;

use App\Enums\VenezuelaState;
use App\Models\Branch;
use App\Models\Company;
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
            'company_id' => Company::factory(),
            'trade_name' => fake()->company(),
            'state' => fake()->randomElement(VenezuelaState::cases()),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'phone_primary' => fake()->e164PhoneNumber(),
            'phone_secondary' => fake()->optional()->e164PhoneNumber(),
            'email' => fake()->freeEmail(),
            'contact_person' => fake()->name(),
        ];
    }
}
