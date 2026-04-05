<?php

namespace Database\Seeders;

use App\Models\Precinto;
use Illuminate\Database\Seeder;

class PrecintoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Precinto::factory()->count(10)->create();
    }
}
