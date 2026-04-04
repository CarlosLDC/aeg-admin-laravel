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
            'tax_id' => Tax::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 10, 100),
            'discount' => $this->faker->randomFloat(2, 0, 20),
            'applied_tax_rate' => $this->faker->randomFloat(4, 0, 0.25),
        ];
    }
}
