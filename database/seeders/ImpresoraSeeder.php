<?php

namespace Database\Seeders;

use App\Models\Impresora;
use Illuminate\Database\Seeder;

class ImpresoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Impresora::factory()->count(10)->create();
    }
}
