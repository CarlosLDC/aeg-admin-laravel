<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
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
            'end_date' => $fakeDate->modify('+2 year')->format('Y-m-d'),
        ];
    }
}
