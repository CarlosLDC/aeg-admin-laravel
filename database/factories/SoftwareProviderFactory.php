<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\SoftwareProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoftwareProvider>
 */
class SoftwareProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => Branch::factory(),
        ];
    }
}
