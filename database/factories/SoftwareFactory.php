<?php

namespace Database\Factories;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
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
            'integration_date' => fake()->optional()->dateTimeThisDecade()?->format('Y-m-d'),
            'operating_systems' => fake()->optional()->randomElements(
                OperatingSystem::cases(),
                fake()->numberBetween(1, count(OperatingSystem::cases()))
            ),
            'programming_languages' => fake()->optional()->randomElements(
                ProgrammingLanguage::cases(),
                fake()->numberBetween(1, count(ProgrammingLanguage::cases()))
            ),
        ];
    }
}
