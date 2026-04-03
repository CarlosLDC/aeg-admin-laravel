<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContracts;

use App\Filament\Resources\Distributors\DistributorResource;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Pages\CreateDistributorContract;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Pages\EditDistributorContract;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Pages\ViewDistributorContract;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Schemas\DistributorContractForm;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Schemas\DistributorContractInfolist;
use App\Filament\Resources\Distributors\Resources\DistributorContracts\Tables\DistributorContractsTable;
use App\Models\DistributorContract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistributorContractResource extends Resource
{
    protected static ?string $model = DistributorContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = DistributorResource::class;

    protected static ?string $modelLabel = 'Contrato';

    protected static ?string $pluralModelLabel = 'Contratos';

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
            // 'create' => CreateDistributorContract::route('/create'),
            // 'view' => ViewDistributorContract::route('/{record}'),
            // 'edit' => EditDistributorContract::route('/{record}/edit'),
        ];
    }
}
