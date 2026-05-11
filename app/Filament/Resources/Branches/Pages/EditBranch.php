<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Resources\Branches\BranchResource;
use App\Filament\Resources\Branches\Pages\Concerns\HandlesBranchRoles;
use App\Models\Company;
use App\Services\Branches\BranchRoleService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBranch extends EditRecord
{
    use HandlesBranchRoles;

    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Company|null $company */
        $company = Company::query()->find($data['company_id']);

        if ($company === null) {
            return $data;
        }

        return [
            ...$data,
            'roles' => app(BranchRoleService::class)->selectedRoles($this->record),
            'tax_id' => $company->tax_id,
            'legal_name' => $company->legal_name,
            'taxpayer_type' => $company->taxpayer_type,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var array<string, mixed> $rawState */
        $rawState = $this->form->getRawState();

        $company = Company::updateOrCreate(
            [
                'tax_id' => $rawState['tax_id'],
            ],
            [
                'legal_name' => $rawState['legal_name'],
                'taxpayer_type' => $rawState['taxpayer_type'],
            ]
        );

        $data['company_id'] = $company->id;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncBranchRoles($this->record, $this->selectedBranchRoles());
    }

    /**
     * @return array<int, mixed>
     */
    private function selectedBranchRoles(): array
    {
        $rawState = $this->form->getRawState();

        return is_array($rawState['roles'] ?? null) ? $rawState['roles'] : [];
    }
}
