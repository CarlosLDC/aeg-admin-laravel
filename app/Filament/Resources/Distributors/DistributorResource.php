<?php

namespace App\Filament\Resources\Distributors;

use App\Filament\Resources\Distributors\Pages\CreateDistributor;
use App\Filament\Resources\Distributors\Pages\EditDistributor;
use App\Filament\Resources\Distributors\Pages\ListDistributors;
use App\Filament\Resources\Distributors\Pages\ViewDistributor;
use App\Filament\Resources\Distributors\Schemas\DistributorForm;
use App\Filament\Resources\Distributors\Schemas\DistributorInfolist;
use App\Filament\Resources\Distributors\Tables\DistributorsTable;
use App\Models\Distributor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DistributorResource extends Resource
{
    protected static ?string $model = Distributor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $modelLabel = 'Distribuidora';

    protected static ?string $pluralModelLabel = 'Distribuidoras';

    protected static ?int $navigationSort = 4;

    protected static string|UnitEnum|null $navigationGroup = 'Aliados y Clientes';

    public static function form(Schema $schema): Schema
    {
        return DistributorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistributorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributorsTable::configure($table);
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
            'index' => ListDistributors::route('/'),
            'create' => CreateDistributor::route('/create'),
            'view' => ViewDistributor::route('/{record}'),
            'edit' => EditDistributor::route('/{record}/edit'),
        ];
    }
}
