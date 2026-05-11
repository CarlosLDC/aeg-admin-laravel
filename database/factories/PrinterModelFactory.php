<?php

namespace Database\Factories;

use App\Enums\DeviceType;
use App\Models\PrinterModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PrinterModel>
 */
class PrinterModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => 'AEG',
            'model' => fake()->unique()->regexify('[A-Z][1-9]'),
            'device_type' => fake()->randomElement(DeviceType::cases()),
            'price' => fake()->randomFloat(2, min: 100, max: 1000),
            'administrative_act' => fake()->optional()->numerify('SNAT/####/####'),
            'certification_date' => fake()->optional()->date('Y-m-d'),
        ];
    }
}
