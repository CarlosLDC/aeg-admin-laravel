<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any roles.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->can('roles.view_any');
    }

    /**
     * Determine whether the user can view the role.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasRole('Admin') || $user->can('roles.view');
    }

    /**
     * Determine whether the user can create roles.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->can('roles.create');
    }

    /**
     * Determine whether the user can update the role.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('Admin') || $user->can('roles.update');
    }

    /**
     * Determine whether the user can delete the role.
     */
    public function delete(User $user, Role $role): bool
    {
        // Prevent deletion of the Admin role itself
        if ($role->name === UserRoles::Admin->value) {
            return false;
        }

        return $user->hasRole(UserRoles::Admin->value) || $user->can('roles.delete');
    }

    /**
     * Prevent force delete for Admin role as well
     */
    public function forceDelete(User $user, Role $role): bool
    {
        if ($role->name === UserRoles::Admin->value) {
            return false;
        }

        return $user->hasRole(UserRoles::Admin->value) || $user->can('roles.delete');
    }
}
