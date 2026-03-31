<?php

namespace Database\Factories;

use App\Models\Firmware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Firmware>
 */
class FirmwareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => fake()->numerify('#.#.#'),
            'release_date' => fake()->dateTimeThisDecade()->format('Y-m-d'),
            'release_notes' => fake()->sentence(),
        ];
    }
}
