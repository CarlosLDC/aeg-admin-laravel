<?php

namespace App\Filament\Resources\Sales\RelationManagers;

use App\Filament\Resources\Sales\Resources\SaleItems\SaleItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SaleItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'saleItems';

    protected static ?string $relatedResource = SaleItemResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->successRedirectUrl(fn (): string => url()->previous()),
            ]);
    }
}
