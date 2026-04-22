<?php

namespace App\Filament\Resources\Distributors\RelationManagers;

use App\Filament\Resources\Printers\PrinterResource;
use App\Filament\Schemas\PrinterSchemas;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PrintersRelationManager extends RelationManager
{
    protected static string $relationship = 'printers';

    protected static ?string $relatedResource = PrinterResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...PrinterSchemas::form(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ...PrinterSchemas::table(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
