<?php

namespace App\Filament\Resources\ServiceCenters\Resources\Technicians;

use App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages\CreateTechnician;
use App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages\EditTechnician;
use App\Filament\Resources\ServiceCenters\Resources\Technicians\Pages\ViewTechnician;
use App\Filament\Resources\ServiceCenters\Resources\Technicians\Schemas\TechnicianForm;
use App\Filament\Resources\ServiceCenters\Resources\Technicians\Schemas\TechnicianInfolist;
use App\Filament\Resources\ServiceCenters\Resources\Technicians\Tables\TechniciansTable;
use App\Filament\Resources\ServiceCenters\ServiceCenterResource;
use App\Models\Technician;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TechnicianResource extends Resource
{
    protected static ?string $model = Technician::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ServiceCenterResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Empleado';

    protected static ?string $pluralModelLabel = 'Empleados';

    public static function form(Schema $schema): Schema
    {
        return TechnicianForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TechnicianInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TechniciansTable::configure($table);
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
            // 'create' => CreateTechnician::route('/create'),
            // 'view' => ViewTechnician::route('/{record}'),
            // 'edit' => EditTechnician::route('/{record}/edit'),
        ];
    }
}
