<?php

namespace Database\Seeders;

use App\Models\PrinterModel;
use Illuminate\Database\Seeder;

class PrinterModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrinterModel::factory()->count(10)->create();
    }
}
