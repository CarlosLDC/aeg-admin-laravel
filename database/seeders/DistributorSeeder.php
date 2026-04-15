<?php

namespace Database\Seeders;

use App\Models\Distributor;
use App\Models\DistributorContact;
use App\Models\DistributorContract;
use Illuminate\Database\Seeder;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Distributor::factory()
            ->count(10)
            ->has(DistributorContact::factory())
            ->has(DistributorContract::factory())
            ->create();
    }
}
