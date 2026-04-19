<?php

namespace Database\Factories;

use App\Enums\TaxpayerType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tax_id' => fake()->unique()->regexify('[VEJPG][0-9]{9}'),
            'legal_name' => fake()->company(),
            'taxpayer_type' => fake()->randomElement(TaxpayerType::cases()),
        ];
    }
}
