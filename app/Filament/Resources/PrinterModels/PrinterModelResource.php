<?php

namespace App\Filament\Resources\PrinterModels;

use App\Filament\Resources\PrinterModels\Pages\CreatePrinterModel;
use App\Filament\Resources\PrinterModels\Pages\EditPrinterModel;
use App\Filament\Resources\PrinterModels\Pages\ListPrinterModels;
use App\Filament\Resources\PrinterModels\Pages\ViewPrinterModel;
use App\Filament\Resources\PrinterModels\Schemas\PrinterModelForm;
use App\Filament\Resources\PrinterModels\Schemas\PrinterModelInfolist;
use App\Filament\Resources\PrinterModels\Tables\PrinterModelsTable;
use App\Models\PrinterModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrinterModelResource extends Resource
{
    protected static ?string $model = PrinterModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'search_name';

    protected static ?string $modelLabel = 'Modelo de Impresora';

    protected static ?string $pluralModelLabel = 'Modelos de Impresora';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?int $navigationSort = 2;

    protected static string|UnitEnum|null $navigationGroup = 'Gestión de Impresoras';

    public static function form(Schema $schema): Schema
    {
        return PrinterModelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrinterModelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrinterModelsTable::configure($table);
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
            'index' => ListPrinterModels::route('/'),
            // 'create' => CreatePrinterModel::route('/create'),
            // 'view' => ViewPrinterModel::route('/{record}'),
            // 'edit' => EditPrinterModel::route('/{record}/edit'),
        ];
    }
}
