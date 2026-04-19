<?php

namespace App\Filament\Resources\Distributors\RelationManagers;

use App\Filament\Resources\Printers\PrinterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PrintersRelationManager extends RelationManager
{
    protected static string $relationship = 'printers';

    protected static ?string $relatedResource = PrinterResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
