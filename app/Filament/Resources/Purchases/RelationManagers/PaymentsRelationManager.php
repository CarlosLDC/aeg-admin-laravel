<?php

namespace App\Filament\Resources\Purchases\RelationManagers;

use App\Filament\Resources\Purchases\Resources\Payments\PaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $relatedResource = PaymentResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->successRedirectUrl(fn (): string => url()->previous()),
            ]);
    }
}
