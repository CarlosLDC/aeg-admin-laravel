<?php

namespace Database\Seeders;

use App\Models\Representative;
use Illuminate\Database\Seeder;

class RepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Representative::factory()->count(10)->create();
    }
}
