<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // keep permissions_selected in $this->data for afterCreate sync, but remove before creating model
        $this->data = $data;

        unset($data['permissions_selected']);

        return $data;
    }

    protected function afterCreate(): void
    {
        parent::afterCreate();

        $permissions = $this->data['permissions_selected'] ?? [];
        $flat = [];
        foreach ($permissions as $p) {
            if (is_array($p)) {
                foreach ($p as $v) {
                    $flat[] = $v;
                }
            } elseif (! empty($p)) {
                $flat[] = $p;
            }
        }

        $flat = array_values(array_unique(array_filter($flat)));

        if (! empty($flat)) {
            $this->getRecord()->syncPermissions($flat);
        }
    }
}
