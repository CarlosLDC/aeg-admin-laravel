<?php

namespace Database\Seeders;

use App\Models\ServiceCenter;
use App\Models\ServiceCenterContact;
use App\Models\ServiceCenterContract;
use Illuminate\Database\Seeder;

class ServiceCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCenter::factory()
            ->count(5)
            ->has(ServiceCenterContact::factory())
            ->has(ServiceCenterContract::factory())
            ->create();
    }
}
