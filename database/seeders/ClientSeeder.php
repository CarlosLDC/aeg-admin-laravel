<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Distributor;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Distributor::all()
            ->each(function ($distributor) {
                Client::factory()
                    ->count(fake()->numberBetween(1, 5))
                    ->for($distributor)
                    ->create();
            });
    }
}
