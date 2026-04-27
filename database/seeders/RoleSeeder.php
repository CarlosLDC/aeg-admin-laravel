<?php

namespace Database\Seeders;

use App\Enums\UserRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guardName = (string) config('auth.defaults.guard', 'web');

        $permissionsByModule = [
            'users' => ['view_any', 'view', 'create', 'update', 'delete'],
            'companies' => ['view_any', 'view', 'create', 'update', 'delete'],
            'branches' => ['view_any', 'view', 'create', 'update', 'delete'],
            'distributors' => ['view_any', 'view', 'create', 'update', 'delete'],
            'distributor_contacts' => ['view_any', 'view', 'create', 'update', 'delete'],
            'distributor_contracts' => ['view_any', 'view', 'create', 'update', 'delete'],
            'service_centers' => ['view_any', 'view', 'create', 'update', 'delete'],
            'service_center_contacts' => ['view_any', 'view', 'create', 'update', 'delete'],
            'service_center_contracts' => ['view_any', 'view', 'create', 'update', 'delete'],
            'clients' => ['view_any', 'view', 'create', 'update', 'delete'],
            'software_providers' => ['view_any', 'view', 'create', 'update', 'delete'],
            'software' => ['view_any', 'view', 'create', 'update', 'delete'],
            'printer_models' => ['view_any', 'view', 'create', 'update', 'delete'],
            'firmware' => ['view_any', 'view', 'create', 'update', 'delete'],
            'printers' => ['view_any', 'view', 'create', 'update', 'delete'],
            'precints' => ['view_any', 'view', 'create', 'update', 'delete'],
            'sales' => ['view_any', 'view', 'create', 'update', 'delete'],
            'sale_items' => ['view_any', 'view', 'create', 'update', 'delete'],
            'payments' => ['view_any', 'view', 'create', 'update', 'delete'],
            'taxes' => ['view_any', 'view', 'create', 'update', 'delete'],
        ];

        $allPermissions = collect($permissionsByModule)
            ->flatMap(static fn (array $actions, string $module): array => array_map(
                static fn (string $action): string => $module.'.'.$action,
                $actions,
            ))
            ->values();

        foreach ($allPermissions as $permissionName) {
            Permission::findOrCreate($permissionName, $guardName);
        }

        $roles = [];

        foreach (UserRolesEnum::cases() as $userRole) {
            $roles[$userRole->value] = Role::findOrCreate($userRole->value, $guardName);
        }

        $roles[UserRolesEnum::Admin->value]->syncPermissions($allPermissions->all());

        $roles[UserRolesEnum::Distributor->value]->syncPermissions([
            'clients.view_any',
            'clients.view',
            'payments.view_any',
            'payments.view',
            'payments.create',
            'payments.update',
            'precints.view_any',
            'precints.view',
            'precints.update',
            'printers.view_any',
            'printers.view',
            'printers.update',
            'sale_items.view_any',
            'sale_items.view',
            'sale_items.create',
            'sale_items.update',
            'sales.view_any',
            'sales.view',
            'sales.create',
            'sales.update',
            'software.view_any',
            'software.view',
        ]);

        $roles[UserRolesEnum::ServiceCenter->value]->syncPermissions([
            'firmware.view_any',
            'firmware.view',
            'precints.view_any',
            'precints.view',
            'precints.update',
            'printer_models.view_any',
            'printer_models.view',
            'printers.view_any',
            'printers.view',
            'printers.update',
            'software.view_any',
            'software.view',
        ]);

        $roles[UserRolesEnum::Client->value]->syncPermissions([
            'precints.view_any',
            'precints.view',
            'printers.view_any',
            'printers.view',
            'software.view_any',
            'software.view',
        ]);
    }
}
