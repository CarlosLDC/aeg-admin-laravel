<?php

namespace App\Filament\Resources\DistributorContracts;

use App\Filament\Resources\DistributorContracts\Pages\CreateDistributorContract;
use App\Filament\Resources\DistributorContracts\Pages\EditDistributorContract;
use App\Filament\Resources\DistributorContracts\Pages\ListDistributorContracts;
use App\Filament\Resources\DistributorContracts\Pages\ViewDistributorContract;
use App\Filament\Resources\DistributorContracts\Schemas\DistributorContractForm;
use App\Filament\Resources\DistributorContracts\Schemas\DistributorContractInfolist;
use App\Filament\Resources\DistributorContracts\Tables\DistributorContractsTable;
use App\Models\DistributorContract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DistributorContractResource extends Resource
{
    protected static ?string $model = DistributorContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $modelLabel = 'Contrato de Distribuidora';

    protected static ?string $pluralModelLabel = 'Contratos de Distribuidoras';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 1;

    protected static string|UnitEnum|null $navigationGroup = 'Contratos';

    public static function form(Schema $schema): Schema
    {
        return DistributorContractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistributorContractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributorContractsTable::configure($table);
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
            'index' => ListDistributorContracts::route('/'),
            // 'create' => CreateDistributorContract::route('/create'),
            // 'view' => ViewDistributorContract::route('/{record}'),
            // 'edit' => EditDistributorContract::route('/{record}/edit'),
        ];
    }
}
