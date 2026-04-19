<?php

namespace App\Filament\Resources\Precints;

use App\Filament\Resources\Precints\Pages\CreatePrecint;
use App\Filament\Resources\Precints\Pages\EditPrecint;
use App\Filament\Resources\Precints\Pages\ListPrecints;
use App\Filament\Resources\Precints\Pages\ViewPrecint;
use App\Filament\Resources\Precints\Schemas\PrecintForm;
use App\Filament\Resources\Precints\Schemas\PrecintInfolist;
use App\Filament\Resources\Precints\Tables\PrecintsTable;
use App\Models\Precint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrecintResource extends Resource
{
    protected static ?string $model = Precint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'serial';

    protected static ?string $modelLabel = 'Precinto';

    protected static ?string $pluralModelLabel = 'Precintos';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 5;

    protected static string|UnitEnum|null $navigationGroup = 'Gestión de Impresoras';

    public static function form(Schema $schema): Schema
    {
        return PrecintForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrecintInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrecintsTable::configure($table);
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
            'index' => ListPrecints::route('/'),
            'create' => CreatePrecint::route('/create'),
            // 'view' => ViewPrecint::route('/{record}'),
            'edit' => EditPrecint::route('/{record}/edit'),
        ];
    }
}
