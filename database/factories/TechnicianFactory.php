<?php

namespace Database\Factories;

use App\Models\ServiceCenter;
use App\Models\Technician;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Technician>
 */
class TechnicianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_center_id' => ServiceCenter::factory(),
            'name' => fake()->name(),
            'national_id' => fake()->unique()->regexify('[VE][0-9]{9}'),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->freeEmail(),
        ];
    }
}
