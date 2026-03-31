<?php

namespace Database\Factories;

use App\Models\SoftwareProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoftwareProvider>
 */
class SoftwareProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'tax_id' => fake()->unique()->regexify('[VEJPG][0-9]{9}'),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->freeEmail(),
            'contact_person' => fake()->name(),
        ];
    }
}
