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
        $operatingSystems = OperatingSystem::cases();
        $programmingLanguages = ProgrammingLanguage::cases();

        return [
            'software_provider_id' => SoftwareProvider::factory(),
            'name' => fake()->word(),
            'version' => fake()->semver(),
            'integration_date' => fake()->dateTimeThisDecade()->format('Y-m-d'),
            'operating_systems' => fake()->randomElements($operatingSystems, fake()->numberBetween(1, count($operatingSystems))),
            'programming_languages' => fake()->randomElements($programmingLanguages, fake()->numberBetween(1, count($programmingLanguages))),
        ];
    }
}
