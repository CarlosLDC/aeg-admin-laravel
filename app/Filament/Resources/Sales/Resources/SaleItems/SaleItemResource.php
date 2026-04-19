<?php

namespace App\Filament\Resources\Sales\Resources\SaleItems;

use App\Filament\Resources\Sales\Resources\SaleItems\Pages\CreateSaleItem;
use App\Filament\Resources\Sales\Resources\SaleItems\Pages\EditSaleItem;
use App\Filament\Resources\Sales\Resources\SaleItems\Pages\ViewSaleItem;
use App\Filament\Resources\Sales\Resources\SaleItems\Schemas\SaleItemForm;
use App\Filament\Resources\Sales\Resources\SaleItems\Schemas\SaleItemInfolist;
use App\Filament\Resources\Sales\Resources\SaleItems\Tables\SaleItemsTable;
use App\Filament\Resources\Sales\SaleResource;
use App\Models\SaleItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SaleItemResource extends Resource
{
    protected static ?string $model = SaleItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = SaleResource::class;

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';

    public static function form(Schema $schema): Schema
    {
        return SaleItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SaleItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SaleItemsTable::configure($table);
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
            // 'create' => CreateSaleItem::route('/create'),
            // 'view' => ViewSaleItem::route('/{record}'),
            // 'edit' => EditSaleItem::route('/{record}/edit'),
        ];
    }
}
