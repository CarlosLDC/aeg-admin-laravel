<?php

namespace App\Filament\Resources\SoftwareProviders;

use App\Filament\Resources\SoftwareProviders\Pages\CreateSoftwareProvider;
use App\Filament\Resources\SoftwareProviders\Pages\EditSoftwareProvider;
use App\Filament\Resources\SoftwareProviders\Pages\ListSoftwareProviders;
use App\Filament\Resources\SoftwareProviders\Pages\ViewSoftwareProvider;
use App\Filament\Resources\SoftwareProviders\RelationManagers\SoftwareRelationManager;
use App\Filament\Resources\SoftwareProviders\Schemas\SoftwareProviderForm;
use App\Filament\Resources\SoftwareProviders\Schemas\SoftwareProviderInfolist;
use App\Filament\Resources\SoftwareProviders\Tables\SoftwareProvidersTable;
use App\Models\SoftwareProvider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SoftwareProviderResource extends Resource
{
    protected static ?string $model = SoftwareProvider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Proveedor de Software';

    protected static ?string $pluralModelLabel = 'Proveedores de Software';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 1;

    protected static string | UnitEnum | null $navigationGroup = 'Software';

    public static function form(Schema $schema): Schema
    {
        return SoftwareProviderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SoftwareProviderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SoftwareProvidersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SoftwareRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSoftwareProviders::route('/'),
            // 'create' => CreateSoftwareProvider::route('/create'),
            'view' => ViewSoftwareProvider::route('/{record}'),
            'edit' => EditSoftwareProvider::route('/{record}/edit'),
        ];
    }
}
