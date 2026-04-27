<?php

use App\Enums\UserRolesEnum;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;

test('it seeds roles from enum without duplicates', function () {
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

    expect(Role::query()->count())->toBe(count($expectedRoles))
        ->and($seededRoles)->toBe($expectedRoles);
});
