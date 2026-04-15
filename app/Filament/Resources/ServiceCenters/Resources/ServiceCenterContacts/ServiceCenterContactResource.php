<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts;

use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Pages\CreateServiceCenterContact;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Pages\EditServiceCenterContact;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Pages\ViewServiceCenterContact;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Schemas\ServiceCenterContactForm;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Schemas\ServiceCenterContactInfolist;
use App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Tables\ServiceCenterContactsTable;
use App\Filament\Resources\ServiceCenters\ServiceCenterResource;
use App\Models\ServiceCenterContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceCenterContactResource extends Resource
{
    protected static ?string $model = ServiceCenterContact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ServiceCenterResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Empleado';

    protected static ?string $pluralModelLabel = 'Empleados';

    public static function form(Schema $schema): Schema
    {
        return ServiceCenterContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiceCenterContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCenterContactsTable::configure($table);
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
            // 'create' => CreateServiceCenterContact::route('/create'),
            // 'view' => ViewServiceCenterContact::route('/{record}'),
            // 'edit' => EditServiceCenterContact::route('/{record}/edit'),
        ];
    }
}
