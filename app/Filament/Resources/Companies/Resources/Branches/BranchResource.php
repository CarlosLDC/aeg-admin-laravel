<?php

namespace App\Filament\Resources\Companies\Resources\Branches;

use App\Filament\Resources\Companies\CompanyResource;
use App\Filament\Resources\Companies\Resources\Branches\Pages\CreateBranch;
use App\Filament\Resources\Companies\Resources\Branches\Pages\EditBranch;
use App\Filament\Resources\Companies\Resources\Branches\Pages\ViewBranch;
use App\Filament\Resources\Companies\Resources\Branches\Schemas\BranchForm;
use App\Filament\Resources\Companies\Resources\Branches\Schemas\BranchInfolist;
use App\Filament\Resources\Companies\Resources\Branches\Tables\BranchesTable;
use App\Models\Branch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Sucursal';

    protected static ?string $pluralModelLabel = 'Sucursales';

    protected static ?string $parentResource = CompanyResource::class;

    protected static ?string $recordTitleAttribute = 'trade_name';

    public static function form(Schema $schema): Schema
    {
        return BranchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BranchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BranchesTable::configure($table);
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
            // 'create' => CreateBranch::route('/create'),
            // 'view' => ViewBranch::route('/{record}'),
            // 'edit' => EditBranch::route('/{record}/edit'),
        ];
    }
}
