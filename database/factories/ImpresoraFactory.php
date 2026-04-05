<?php

namespace Database\Factories;

use App\Enums\DeviceType;
use App\Enums\ImpresoraStatus;
use App\Models\Branch;
use App\Models\Distributor;
use App\Models\Firmware;
use App\Models\Impresora;
use App\Models\PrinterModel;
use App\Models\Purchase;
use App\Models\Software;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Impresora>
 */
class ImpresoraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $relatedId = static fn (string $modelClass, Factory $factory): int|Factory => $modelClass::query()->inRandomOrder()->value('id') ?? $factory;

        $status = fake()->randomElement(ImpresoraStatus::cases());
        $deviceType = fake()->randomElement(DeviceType::cases());
        $hasInstallationDate = in_array($status, [ImpresoraStatus::Instalada, ImpresoraStatus::Mantenimiento], true);

        return [
            'id_modelo_impresora' => $relatedId(PrinterModel::class, PrinterModel::factory()),
            'id_software' => fake()->boolean(70) ? $relatedId(Software::class, Software::factory()) : null,
            'id_compra' => fake()->boolean(60) ? $relatedId(Purchase::class, Purchase::factory()) : null,
            'id_sucursal' => fake()->boolean(85) ? $relatedId(Branch::class, Branch::factory()) : null,
            'serial_fiscal' => fake()->unique()->regexify('[A-Z]{3}[0-9]{7}'),
            'precio_venta_final' => fake()->randomFloat(2, 120, 2500),
            'estatus' => $status,
            'id_firmware' => fake()->boolean(70) ? $relatedId(Firmware::class, Firmware::factory()) : null,
            'id_distribuidora' => fake()->boolean(60) ? $relatedId(Distributor::class, Distributor::factory()) : null,
            'se_pago' => fake()->boolean(80),
            'fecha_instalacion' => $hasInstallationDate ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'version_firmware' => fake()->optional()->numerify('#.#.#'),
            'direccion_mac' => strtoupper(fake()->macAddress()),
            'tipo_dispositivo' => $deviceType,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
