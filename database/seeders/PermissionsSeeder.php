<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
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
        // Create roles from enum
        foreach (UserRoles::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }

        // Define resources and actions to generate granular permissions
        $resources = [
            'users', 'roles', 'companies', 'distributors', 'printer_models', 'printers',
            'sales', 'payments', 'clients', 'service_centers', 'firmwares', 'branches', 'precints', 'settings',
        ];

        $actions = ['view_any', 'view', 'create', 'update', 'delete', 'export', 'restore', 'force_delete'];

        $permissionsCreated = [];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $name = sprintf('%s.%s', $resource, $action);
                $permissionsCreated[] = Permission::firstOrCreate(['name' => $name]);
            }
        }

        // Add a couple of special permissions (panel access, manage settings)
        $special = [
            'filament.access',
            'settings.manage',
        ];

        foreach ($special as $perm) {
            $permissionsCreated[] = Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign all permissions to Admin role
        $adminRole = Role::firstWhere('name', UserRoles::Admin->value);
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }

        // Create initial admin/distributor users (idempotent)
        $adminUser = User::firstOrCreate([
            'email' => 'segar12345@gmail.com',
        ], [
            'name' => 'Edgar Rivera',
            'password' => Hash::make('aeg-r1'),
        ]);
        $adminUser->assignRole(UserRoles::Admin->value);

        $distUser = User::firstOrCreate([
            'email' => 'cca.gomez2014@gmail.com',
        ], [
            'name' => 'Carlos',
            'password' => Hash::make('aeg-r1'),
        ]);
        $distUser->assignRole(UserRoles::Distributor->value);
    }
}
