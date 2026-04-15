<?php

namespace Database\Factories;

use App\Models\ServiceCenterContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceCenterContact>
 */
class ServiceCenterContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'national_id' => fake()->unique()->regexify('[VE][0-9]{7,8}'),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->freeEmail(),
        ];
    }
}
