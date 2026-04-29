<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (UserRoles::cases() as $role) {
            Role::create(['name' => $role->value]);
        }

        User::factory()->create([
            'name' => 'Edgar Rivera',
            'email' => 'segar12345@gmail.com',
            'password' => 'aeg-r1',
        ])->assignRole(UserRoles::Admin);

        User::factory()->create([
            'name' => 'Carlos',
            'email' => 'cca.gomez2014@gmail.com',
            'password' => 'aeg-r1',
        ])->assignRole(UserRoles::Distributor);
    }
}
