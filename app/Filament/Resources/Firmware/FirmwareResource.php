<?php

namespace App\Filament\Resources\Firmware;

use App\Filament\Resources\Firmware\Pages\CreateFirmware;
use App\Filament\Resources\Firmware\Pages\EditFirmware;
use App\Filament\Resources\Firmware\Pages\ListFirmware;
use App\Filament\Resources\Firmware\Pages\ViewFirmware;
use App\Filament\Resources\Firmware\Schemas\FirmwareForm;
use App\Filament\Resources\Firmware\Schemas\FirmwareInfolist;
use App\Filament\Resources\Firmware\Tables\FirmwareTable;
use App\Models\Firmware;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FirmwareResource extends Resource
{
    protected static ?string $model = Firmware::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $recordTitleAttribute = 'version';

    protected static ?string $modelLabel = 'Firmware';

    protected static ?int $navigationSort = 2;

    protected static string | UnitEnum | null $navigationGroup = 'Impresoras';

    public static function form(Schema $schema): Schema
    {
        return FirmwareForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FirmwareInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FirmwareTable::configure($table);
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
            'index' => ListFirmware::route('/'),
            // 'create' => CreateFirmware::route('/create'),
            // 'view' => ViewFirmware::route('/{record}'),
            // 'edit' => EditFirmware::route('/{record}/edit'),
        ];
    }
}
