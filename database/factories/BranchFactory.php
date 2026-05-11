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
            // Información fiscal
            'company_id' => Company::factory(),
            'state' => fake()->randomElement(VenezuelaState::cases()),
            'city' => fake()->city(),
            'address' => fake()->address(),
            // Información general
            'trade_name' => fake()->company(),
            // Contacto
            'phone_primary' => fake()->optional()->e164PhoneNumber(),
            'phone_secondary' => fake()->optional()->e164PhoneNumber(),
            'email' => fake()->optional()->freeEmail(),
            'contact_person' => fake()->optional()->name(),
        ];
    }
}
