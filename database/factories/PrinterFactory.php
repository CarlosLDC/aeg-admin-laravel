<?php

namespace Database\Factories;

use App\Enums\PrinterStatus;
use App\Models\Firmware;
use App\Models\Printer;
use App\Models\PrinterModel;
use App\Models\Sale;
use App\Models\Software;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Printer>
 */
class PrinterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fiscal_serial_number' => fake()->unique()->regexify('GRA[0-9]{7}'),
            'printer_model_id' => PrinterModel::factory(),
            'mac_address' => fake()->optional()->macAddress(),
            'firmware_id' => fake()->boolean(70) ? Firmware::factory() : null,
            'software_id' => fake()->boolean(70) ? Software::factory() : null,
            'status' => fake()->randomElement(PrinterStatus::cases()),
            'installation_date' => fake()->optional()->date(),
            'client_id' => null,
            'sale_id' => fake()->boolean(50) ? Sale::factory() : null,
            'final_sale_price' => fake()->optional()->randomFloat(2, min: 1000, max: 1100),
            'is_paid' => fake()->boolean(),
            'headers' => null,
        ];
    }
}
