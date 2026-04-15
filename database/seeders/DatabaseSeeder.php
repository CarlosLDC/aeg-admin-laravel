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
            // Aliados y Clientes
            DistributorSeeder::class,
            ServiceCenterSeeder::class,
            ClientSeeder::class,
            // Software
            SoftwareProviderSeeder::class,
            // Impresoras
            PrinterModelSeeder::class,
            FirmwareSeeder::class,
            ImpresoraSeeder::class,
            PrecintoSeeder::class,
            // Gestión de Compras
            PurchaseSeeder::class,
            PaymentSeeder::class,
            TaxSeeder::class,
        ]);
    }
}
