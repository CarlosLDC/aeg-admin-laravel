<?php

namespace App\Filament\Resources\Branches\Pages\Concerns;

use App\Models\Branch;
use App\Services\Branches\BranchRoleService;
use Filament\Notifications\Notification;

trait HandlesBranchRoles
{
    /**
     * @param  array<int, mixed>  $roles
     */
    protected function syncBranchRoles(Branch $branch, array $roles): void
    {
        $failedRoles = app(BranchRoleService::class)->sync($branch, $roles);

        if ($failedRoles === []) {
            Notification::make()
                ->title('Roles actualizados')
                ->body('Los roles se actualizaron correctamente.')
                ->success()
                ->send();

            return;
        }

        Notification::make()
            ->title('Error al actualizar roles')
            ->body('No se pudieron actualizar los siguientes roles: '.implode(', ', $failedRoles).'.')
            ->danger()
            ->send();
    }
}
