<?php

namespace Database\Seeders;

use App\Models\Precint;
use Illuminate\Database\Seeder;

class PrecintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Precint::factory()->count(10)->create();
    }
}
