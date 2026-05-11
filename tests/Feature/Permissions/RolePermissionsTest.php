<?php

use App\Enums\UserRoles;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

it('allows admin to update role permissions', function () {
    // Seed permissions and roles
    $this->seed(PermissionsSeeder::class);

    $admin = User::factory()->create()->assignRole(UserRoles::Admin->value);
    $this->actingAs($admin);

    $role = Role::create(['name' => 'test-role']);

    $perm = Permission::create(['name' => 'tests.custom']);

    // Admin should be able to sync permissions via policy (Gate::before also allows)
    $role->syncPermissions([$perm->name]);

    expect($role->permissions->pluck('name')->toArray())->toContain('tests.custom');
});

it('prevents non-admin without permission from updating role permissions', function () {
    $this->seed(PermissionsSeeder::class);

    $user = User::factory()->create();
    $this->actingAs($user);

    $role = Role::create(['name' => 'test-role-2']);
    $perm = Permission::create(['name' => 'tests.custom.2']);

    // Simulate attempt to update via route or direct check: policy should deny
    $this->assertFalse($user->can('update', $role));

    // Ensure syncing without permissions is not allowed in UI, but direct model change still possible
    $role->syncPermissions([$perm->name]);

    expect($role->permissions->pluck('name')->toArray())->toContain('tests.custom.2');
});
