<?php

namespace App\Services\Branches;

use App\Enums\BranchRoles;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\QueryException;

class BranchRoleService
{
    /**
     * @return array<int, BranchRoles>
     */
    public function selectedRoles(Branch $branch): array
    {
        return array_values(array_filter(
            BranchRoles::cases(),
            fn (BranchRoles $role): bool => $this->relationForRole($branch, $role)->exists()
        ));
    }

    public function primaryRoleValue(Branch $branch): ?string
    {
        return $this->selectedRoleValues($branch)[0] ?? null;
    }

    /**
     * @return array<int, string>
     */
    public function selectedRoleValues(Branch $branch): array
    {
        return array_map(
            static fn (BranchRoles $role): string => $role->value,
            $this->selectedRoles($branch)
        );
    }

    /**
     * @param  array<int, BranchRoles|string>  $roles
     * @return array<int, string>
     */
    public function sync(Branch $branch, array $roles): array
    {
        $selectedRoleValues = array_map(
            static fn (BranchRoles|string $role): string => $role instanceof BranchRoles ? $role->value : $role,
            $roles
        );

        $failedRoles = [];

        foreach (BranchRoles::cases() as $role) {
            try {
                $relation = $this->relationForRole($branch, $role);

                if (in_array($role->value, $selectedRoleValues, true)) {
                    $relation->firstOrCreate([]);
                } else {
                    $relation->delete();
                }
            } catch (QueryException) {
                $failedRoles[] = $role->getLabel();
            }
        }

        return $failedRoles;
    }

    private function relationForRole(Branch $branch, BranchRoles $role): HasOne
    {
        return match ($role) {
            BranchRoles::Distributor => $branch->distributor(),
            BranchRoles::ServiceCenter => $branch->serviceCenter(),
            BranchRoles::SoftwareProvider => $branch->softwareProvider(),
            BranchRoles::Client => $branch->client(),
        };
    }
}
