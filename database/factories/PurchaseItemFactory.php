<?php

namespace Database\Factories;

use App\Models\PrinterModel;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseItem>
 */
class PurchaseItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_id' => Purchase::factory(),
            'printer_model_id' => PrinterModel::factory(),
            'quantity' => fake()->numberBetween(1, 10),
            'discount' => fake()->randomFloat(2, min: 0, max: 50),
            'tax_id' => Tax::factory(),
        ];
    }
}
