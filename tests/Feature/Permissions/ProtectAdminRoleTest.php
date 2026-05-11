<?php

use App\Enums\UserRoles;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

it('prevents deletion of the Admin role even by an Admin user', function () {
    $this->seed(PermissionsSeeder::class);

    $adminUser = User::factory()->create()->assignRole(UserRoles::Admin->value);
    $this->actingAs($adminUser);

    $adminRole = Role::firstWhere('name', UserRoles::Admin->value);
    expect($adminRole)->not->toBeNull();

    // Attempt to delete via policy
    $this->assertFalse(Gate::allows('delete', $adminRole));
});
