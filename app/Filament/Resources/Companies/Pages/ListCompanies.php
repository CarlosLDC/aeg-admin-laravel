<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\Company;
use App\Models\Distributor;
use App\Models\ServiceCenter;
use App\Models\SoftwareProvider;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

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
                ->badge(Company::count()),
            'distributors' => Tab::make('Distribuidoras')
                ->modifyQueryUsing(fn ($query) => $query->has('distributors'))
                ->badge(Distributor::count()),
            'serviceCenters' => Tab::make('Centros de Servicio')
                ->modifyQueryUsing(fn ($query) => $query->has('serviceCenters'))
                ->badge(ServiceCenter::count()),
            'softwareProviders' => Tab::make('Casas de Software')
                ->modifyQueryUsing(fn ($query) => $query->has('softwareProviders'))
                ->badge(SoftwareProvider::count()),
        ];
    }
}
