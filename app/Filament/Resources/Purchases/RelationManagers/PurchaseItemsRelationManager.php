<?php

namespace App\Filament\Resources\Purchases\RelationManagers;

use App\Filament\Resources\Purchases\Resources\PurchaseItems\PurchaseItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PurchaseItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'purchaseItems';

    protected static ?string $relatedResource = PurchaseItemResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->successRedirectUrl(fn (): string => url()->previous()),
            ]);
    }
}
