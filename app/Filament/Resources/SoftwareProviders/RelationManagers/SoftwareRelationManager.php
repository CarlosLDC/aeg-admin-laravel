<?php

namespace App\Filament\Resources\SoftwareProviders\RelationManagers;

use App\Filament\Resources\Software\SoftwareResource;
use App\Filament\Schemas\SoftwareSchemas;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SoftwareRelationManager extends RelationManager
{
    protected static string $relationship = 'software';

    protected static ?string $relatedResource = SoftwareResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...SoftwareSchemas::form(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ...SoftwareSchemas::table(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
