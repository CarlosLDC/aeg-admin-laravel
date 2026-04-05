<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchases = Purchase::query()->get();

        if ($purchases->isEmpty()) {
            $purchases = Purchase::factory()->count(10)->create();
        }

        $purchases->each(function (Purchase $purchase): void {
            Payment::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($purchase)
                ->create();
        });
    }
}
