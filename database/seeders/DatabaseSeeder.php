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
            PrinterModelSeeder::class,
            FirmwareSeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            DistributorSeeder::class,
            ClientSeeder::class,
            ServiceCenterSeeder::class,
            SoftwareProviderSeeder::class,
            SoftwareSeeder::class,
            TechnicianSeeder::class,
            RepresentativeSeeder::class,
            DistributorContractSeeder::class,
            ServiceCenterContractSeeder::class,
            PurchaseSeeder::class,
            ImpresoraSeeder::class,
            PrecintoSeeder::class,
            PaymentSeeder::class,
            TaxSeeder::class,
        ]);
    }
}
