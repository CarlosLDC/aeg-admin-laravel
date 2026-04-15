<?php

namespace Database\Factories;

use App\Models\DistributorContract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DistributorContract>
 */
class DistributorContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeDate = fake()->dateTimeThisDecade();

        return [
            'photo_path' => fake()->imageUrl(),
            'start_date' => $fakeDate->format('Y-m-d'),
            'end_date' => $fakeDate->modify('+2 years')->format('Y-m-d'),
        ];
    }
}
