<?php

namespace Database\Seeders;

use App\Models\ServiceCenterContract;
use Illuminate\Database\Seeder;

class ServiceCenterContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCenterContract::factory()->count(10)->create();
    }
}
