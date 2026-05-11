<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // store permissions for afterSave sync and remove from update payload
        $this->data = $data;

        unset($data['permissions_selected']);

        return $data;
    }

    protected function afterSave(): void
    {
        parent::afterSave();

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
