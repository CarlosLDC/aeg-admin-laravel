<?php

namespace Database\Seeders;

use App\Models\ServiceCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCenter::factory()->count(10)->create();
    }
}
