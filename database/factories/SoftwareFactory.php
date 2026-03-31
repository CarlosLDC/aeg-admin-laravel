<?php

namespace Database\Factories;

use App\Models\Software;
use App\Models\SoftwareProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Software>
 */
class SoftwareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'software_provider_id' => SoftwareProvider::factory(),
            'name' => fake()->word(),
            'version' => fake()->semver(),
            'integration_date' => fake()->dateTimeThisDecade()->format('Y-m-d'),
        ];
    }
}
