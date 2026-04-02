<?php

namespace Database\Seeders;

use App\Models\DistributorContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistributorContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DistributorContract::factory()->count(10)->create();
    }
}
