<?php

use App\Enums\UserRolesEnum;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('it seeds roles and permissions without duplicates', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoleSeeder::class);

    $expectedRoles = collect(UserRolesEnum::cases())
        ->map(static fn (UserRolesEnum $role): string => $role->value)
        ->sort()
        ->values()
        ->all();

    $seededRoles = Role::query()
        ->pluck('name')
        ->sort()
        ->values()
        ->all();

    $allPermissions = Permission::query()->pluck('name')->sort()->values()->all();

    $adminPermissionNames = Role::query()
        ->where('name', UserRolesEnum::Admin->value)
        ->firstOrFail()
        ->permissions()
        ->pluck('name')
        ->sort()
        ->values()
        ->all();

    expect(Role::query()->count())->toBe(count($expectedRoles))
        ->and($seededRoles)->toBe($expectedRoles)
        ->and(count($allPermissions))->toBe(count(array_unique($allPermissions)))
        ->and($allPermissions)->toContain('users.view_any', 'sales.create', 'payments.update', 'precints.view')
        ->and($adminPermissionNames)->toBe($allPermissions);
});
