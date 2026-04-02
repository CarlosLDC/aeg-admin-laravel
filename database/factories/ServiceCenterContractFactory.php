<?php

namespace Database\Factories;

use App\Models\ServiceCenter;
use App\Models\ServiceCenterContract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceCenterContract>
 */
class ServiceCenterContractFactory extends Factory
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
            'service_center_id' => ServiceCenter::factory(),
            'photo_path' => fake()->imageUrl(),
            'start_date' => $fakeDate->format('Y-m-d'),
            'end_date' => $fakeDate->modify('+2 years')->format('Y-m-d'),
        ];
    }
}
