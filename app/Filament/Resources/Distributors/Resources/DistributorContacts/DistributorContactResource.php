<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContacts;

use App\Filament\Resources\Distributors\DistributorResource;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Pages\CreateDistributorContact;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Pages\EditDistributorContact;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Pages\ViewDistributorContact;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Schemas\DistributorContactForm;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Schemas\DistributorContactInfolist;
use App\Filament\Resources\Distributors\Resources\DistributorContacts\Tables\DistributorContactsTable;
use App\Models\DistributorContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistributorContactResource extends Resource
{
    protected static ?string $model = DistributorContact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = DistributorResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Empleado';

    protected static ?string $pluralModelLabel = 'Empleados';

    public static function form(Schema $schema): Schema
    {
        return DistributorContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistributorContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributorContactsTable::configure($table);
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
            // 'create' => CreateDistributorContact::route('/create'),
            // 'view' => ViewDistributorContact::route('/{record}'),
            // 'edit' => EditDistributorContact::route('/{record}/edit'),
        ];
    }
}
