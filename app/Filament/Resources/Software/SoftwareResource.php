<?php

namespace App\Filament\Resources\Software;

use App\Filament\Resources\Software\Pages\CreateSoftware;
use App\Filament\Resources\Software\Pages\EditSoftware;
use App\Filament\Resources\Software\Pages\ListSoftware;
use App\Filament\Resources\Software\Pages\ViewSoftware;
use App\Filament\Resources\Software\Schemas\SoftwareForm;
use App\Filament\Resources\Software\Schemas\SoftwareInfolist;
use App\Filament\Resources\Software\Tables\SoftwareTable;
use App\Models\Software;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Software';

    protected static ?string $pluralModelLabel = 'Catálogo de Software';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 2;

    protected static string | UnitEnum | null $navigationGroup = 'Software';

    public static function form(Schema $schema): Schema
    {
        return SoftwareForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SoftwareInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SoftwareTable::configure($table);
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
            'index' => ListSoftware::route('/'),
            'create' => CreateSoftware::route('/create'),
            'view' => ViewSoftware::route('/{record}'),
            'edit' => EditSoftware::route('/{record}/edit'),
        ];
    }
}
