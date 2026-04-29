<?php

namespace App\Filament\Resources\Companies\Resources\Branches\Pages;

use App\Enums\BranchRoles;
use App\Filament\Resources\Companies\Resources\Branches\BranchResource;
use App\Models\Branch;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\QueryException;

class EditBranch extends EditRecord
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('updateRoles')
                ->label('Editar Roles')
                // Aspecto del botón
                ->outlined()
                ->color('gray')
                ->icon('heroicon-o-pencil-square')
                // Tipo de modal
                ->slideOver()
                // Información del modal
                ->modalHeading('Editar Roles')
                ->modalDescription('Seleccione los roles que deseee asignar a esta sucursal. Es posible que no pueda desasignar roles existentes.')
                ->modalSubmitActionLabel('Guardar cambios')
                // Lógica del formulario
                ->fillForm(fn (Branch $record): array => [
                    'selected_roles' => $record->roles,
                ])
                ->schema([
                    CheckboxList::make('selected_roles')
                        ->hiddenLabel()
                        ->options(BranchRoles::class)
                        ->columns(2),
                ])
                ->action(function (array $data, Branch $record): void {
                    $selectedRoles = $data['selected_roles'];
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
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
