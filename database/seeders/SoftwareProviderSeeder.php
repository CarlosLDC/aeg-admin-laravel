<?php

namespace Database\Seeders;

use App\Models\SoftwareProvider;
use Illuminate\Database\Seeder;

class SoftwareProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoftwareProvider::factory()->count(10)->create();
    }
}
