<?php

namespace Database\Factories;

use App\Enums\ColorPrecinto;
use App\Enums\EstatusPrecinto;
use App\Models\Impresora;
use App\Models\Precinto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Precinto>
 */
class PrecintoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(EstatusPrecinto::cases());
        $hasInstallationDate = in_array($status, [EstatusPrecinto::Instalado, EstatusPrecinto::Retirado], true);
        $hasRetireDate = $status === EstatusPrecinto::Retirado;

        return [
            'id_impresora' => fake()->boolean(80) ? (Impresora::query()->inRandomOrder()->value('id') ?? Impresora::factory()) : null,
            'serial' => fake()->unique()->regexify('[A-Z0-9]{10,16}'),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'fecha_instalacion' => $hasInstallationDate ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'fecha_retiro' => $hasRetireDate ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'color' => fake()->randomElement(ColorPrecinto::cases()),
            'estatus' => $status,
        ];
    }
}
