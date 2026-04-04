<?php

namespace Database\Seeders;

use App\Models\Firmware;
use Illuminate\Database\Seeder;

class FirmwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Firmware::factory()->count(10)->create();
    }
}
