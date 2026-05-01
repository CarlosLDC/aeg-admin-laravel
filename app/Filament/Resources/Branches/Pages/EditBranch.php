<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Enums\BranchRoles;
use App\Filament\Resources\Branches\BranchResource;
use App\Filament\Resources\Companies\CompanyResource;
use App\Models\Branch;
use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\QueryException;

class EditBranch extends EditRecord
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('update_roles')
                    ->label('Editar Roles')
                    // Aspecto del botón
                    ->icon('heroicon-o-pencil-square')
                    // Tipo de modal
                    ->slideOver()
                    // Información del modal
                    ->modalHeading('Editar Roles')
                    ->modalDescription('Seleccione los roles que deseee asignar a esta sucursal. Es posible que no pueda desasignar roles existentes.')
                    ->modalSubmitActionLabel('Guardar cambios')
                    // Lógica del formulario
                    ->fillForm(fn (Branch $record): array => [
                        'roles' => $record->roles,
                    ])
                    ->schema([
                        CheckboxList::make('roles')
                            ->hiddenLabel()
                            ->options(BranchRoles::class)
                            ->columns(2),
                    ])
                    ->action(function (array $data, Branch $record): void {
                        $selectedRoles = $data['roles'] ?? [];
                        $failedToDelete = [];

                        try {
                            if (in_array(BranchRoles::Distributor, $selectedRoles)) {
                                $record->distributor()->firstOrCreate([]);
                            } else {
                                $record->distributor()->delete();
                            }
                        } catch (QueryException $e) {
                            $failedToDelete[] = BranchRoles::Distributor->getLabel();
                        }

                        try {
                            if (in_array(BranchRoles::ServiceCenter, $selectedRoles)) {
                                $record->serviceCenter()->firstOrCreate([]);
                            } else {
                                $record->serviceCenter()->delete();
                            }
                        } catch (QueryException $e) {
                            $failedToDelete[] = BranchRoles::ServiceCenter->getLabel();
                        }

                        try {
                            if (in_array(BranchRoles::SoftwareProvider, $selectedRoles)) {
                                $record->softwareProvider()->firstOrCreate([]);
                            } else {
                                $record->softwareProvider()->delete();
                            }
                        } catch (QueryException $e) {
                            $failedToDelete[] = BranchRoles::SoftwareProvider->getLabel();
                        }

                        try {
                            if (in_array(BranchRoles::Client, $selectedRoles)) {
                                $record->client()->firstOrCreate([]);
                            } else {
                                $record->client()->delete();
                            }
                        } catch (QueryException $e) {
                            $failedToDelete[] = BranchRoles::Client->getLabel();
                        }

                        if (empty($failedToDelete)) {
                            Notification::make()
                                ->title('Roles actualizados')
                                ->body('Los roles se actualizaron correctamente.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al actualizar roles')
                                ->body('No se pudieron actualizar los siguientes roles: '.implode(', ', $failedToDelete).'.')
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('view_company')
                    ->label('Ver Ficha Fiscal')
                    ->icon('heroicon-o-identification')
                    ->url(fn () => CompanyResource::getUrl('edit', ['record' => $this->record->company_id])),
            ])
                ->label('Más acciones')
                ->outlined()
                ->color('gray')
                ->icon(Heroicon::EllipsisVertical)
                ->button(),
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    // Hacer los roles de la maner sencilla

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $company = Company::find($data['company_id']);

        if ($company === null) {
            return $data;
        }

        return array_merge(
            $data,
            [
                'tax_id' => $company->tax_id,
                'legal_name' => $company->legal_name,
                'taxpayer_type' => $company->taxpayer_type,
            ]
        );
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $company = Company::updateOrCreate(
            [
                'tax_id' => $data['tax_id'],
            ],
            [
                'legal_name' => $data['legal_name'],
                'taxpayer_type' => $data['taxpayer_type'],
            ]
        );

        unset(
            $data['tax_id'],
            $data['legal_name'],
            $data['taxpayer_type'],
        );

        $data['company_id'] = $company->id;

        return $data;
    }
}
