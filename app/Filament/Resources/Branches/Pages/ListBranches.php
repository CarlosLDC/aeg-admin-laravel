<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Resources\Branches\BranchResource;
use App\Models\Branch;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas')
                ->badge(
                    Branch::count()
                ),
            'distributors' => Tab::make('Distribuidoras')
                ->modifyQueryUsing(
                    fn ($query) => $query->has('distributor')
                )
                ->badge(
                    Branch::whereHas('distributor')->count()
                ),
            'serviceCenters' => Tab::make('Centros de Servicio')
                ->modifyQueryUsing(
                    fn ($query) => $query->has('serviceCenter')
                )
                ->badge(
                    Branch::whereHas('serviceCenter')->count()
                ),
            'softwareProviders' => Tab::make('Casas de Software')
                ->modifyQueryUsing(
                    fn ($query) => $query->has('softwareProvider')
                )
                ->badge(
                    Branch::whereHas('softwareProvider')->count()
                ),
            'clients' => Tab::make('Clientes')
                ->modifyQueryUsing(
                    fn ($query) => $query->has('client')
                )
                ->badge(
                    Branch::whereHas('client')->count()
                ),
        ];
    }
}
