<?php

namespace App\Filament\Resources\Precintos;

use App\Filament\Resources\Precintos\Pages\CreatePrecinto;
use App\Filament\Resources\Precintos\Pages\EditPrecinto;
use App\Filament\Resources\Precintos\Pages\ListPrecintos;
use App\Filament\Resources\Precintos\Pages\ViewPrecinto;
use App\Filament\Resources\Precintos\Schemas\PrecintoForm;
use App\Filament\Resources\Precintos\Schemas\PrecintoInfolist;
use App\Filament\Resources\Precintos\Tables\PrecintosTable;
use App\Models\Precinto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrecintoResource extends Resource
{
    protected static ?string $model = Precinto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'serial';

    protected static ?string $modelLabel = 'Precinto';

    protected static ?string $pluralModelLabel = 'Precintos';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 4;

    protected static string|UnitEnum|null $navigationGroup = 'Impresoras';

    public static function form(Schema $schema): Schema
    {
        return PrecintoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrecintoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrecintosTable::configure($table);
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
            'index' => ListPrecintos::route('/'),
            'create' => CreatePrecinto::route('/create'),
            'view' => ViewPrecinto::route('/{record}'),
            'edit' => EditPrecinto::route('/{record}/edit'),
        ];
    }
}
