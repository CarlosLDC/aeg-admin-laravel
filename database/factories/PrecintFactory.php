<?php

namespace Database\Factories;

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use App\Models\Precint;
use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Precint>
 */
class PrecintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(EstatusPrecint::cases());
        $hasInstallationDate = in_array($status, [EstatusPrecint::Instalado, EstatusPrecint::Retirado], true);
        $hasRetireDate = $status === EstatusPrecint::Retirado;

        return [
            'printer_id' => fake()->boolean(80) ? (Printer::query()->inRandomOrder()->value('id') ?? Printer::factory()) : null,
            'serial' => fake()->unique()->regexify('[A-Z0-9]{10,16}'),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'fecha_instalacion' => $hasInstallationDate ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'fecha_retiro' => $hasRetireDate ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'color' => fake()->randomElement(ColorPrecint::cases()),
            'estatus' => $status,
        ];
    }
}
