<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sale::query()->get();

        if ($sales->isEmpty()) {
            $sales = Sale::factory()->count(10)->create();
        }

        $sales->each(function (Sale $sale): void {
            Payment::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($sale)
                ->create();
        });
    }
}
