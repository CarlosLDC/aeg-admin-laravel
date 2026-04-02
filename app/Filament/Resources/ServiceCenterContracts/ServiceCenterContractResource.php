<?php

namespace App\Filament\Resources\ServiceCenterContracts;

use App\Filament\Resources\ServiceCenterContracts\Pages\CreateServiceCenterContract;
use App\Filament\Resources\ServiceCenterContracts\Pages\EditServiceCenterContract;
use App\Filament\Resources\ServiceCenterContracts\Pages\ListServiceCenterContracts;
use App\Filament\Resources\ServiceCenterContracts\Pages\ViewServiceCenterContract;
use App\Filament\Resources\ServiceCenterContracts\Schemas\ServiceCenterContractForm;
use App\Filament\Resources\ServiceCenterContracts\Schemas\ServiceCenterContractInfolist;
use App\Filament\Resources\ServiceCenterContracts\Tables\ServiceCenterContractsTable;
use App\Models\ServiceCenterContract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ServiceCenterContractResource extends Resource
{
    protected static ?string $model = ServiceCenterContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $modelLabel = 'Contrato de Centro de Servicio';

    protected static ?string $pluralModelLabel = 'Contratos de Centros de Servicio';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 2;

    protected static string|UnitEnum|null $navigationGroup = 'Contratos';

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
            'index' => ListServiceCenterContracts::route('/'),
            // 'create' => CreateServiceCenterContract::route('/create'),
            // 'view' => ViewServiceCenterContract::route('/{record}'),
            // 'edit' => EditServiceCenterContract::route('/{record}/edit'),
        ];
    }
}
