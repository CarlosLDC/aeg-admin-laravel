<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            // Aliados y Clientes
            DistributorSeeder::class,
            ServiceCenterSeeder::class,
            ClientSeeder::class,
            // Software
            SoftwareProviderSeeder::class,
            // Printers
            PrinterModelSeeder::class,
            FirmwareSeeder::class,
            PrinterSeeder::class,
            PrecintSeeder::class,
            // Gestión de Ventas
            SaleSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
