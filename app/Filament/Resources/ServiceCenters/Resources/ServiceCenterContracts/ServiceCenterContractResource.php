<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Pages\CreateServiceCenterContract;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Pages\EditServiceCenterContract;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Pages\ViewServiceCenterContract;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Schemas\ServiceCenterContractForm;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Schemas\ServiceCenterContractInfolist;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContracts\Tables\ServiceCenterContractsTable;
use App\Filament\Resources\ServiceCenters\ServiceCenterResource;
use App\Models\ServiceCenterContract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceCenterContractResource extends Resource
{
    protected static ?string $model = ServiceCenterContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ServiceCenterResource::class;

    protected static ?string $modelLabel = 'Contrato';

    protected static ?string $pluralModelLabel = 'Contratos';

    public static function form(Schema $schema): Schema
    {
        return ServiceCenterContractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiceCenterContractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCenterContractsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            // 'create' => CreateServiceCenterContract::route('/create'),
            // 'view' => ViewServiceCenterContract::route('/{record}'),
            // 'edit' => EditServiceCenterContract::route('/{record}/edit'),
        ];
    }
}
