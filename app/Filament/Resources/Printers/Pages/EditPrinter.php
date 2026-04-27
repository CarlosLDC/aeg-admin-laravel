<?php

namespace App\Filament\Resources\Printers\Pages;

use App\Filament\Resources\Printers\PrinterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Resources\Pages\EditRecord;

class EditPrinter extends EditRecord
{
    protected static string $resource = PrinterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make('updateHeaders')
                ->label('Editar Encabezados')
                ->button()
                ->outlined()
                ->color('gray')
                ->modalHeading('Editar Encabezados')
                ->icon('heroicon-o-pencil-square')
                ->slideOver()
                ->schema([
                    KeyValue::make('headers')
                        ->hiddenLabel()
                        ->reorderable(),
                ]),
            DeleteAction::make(),
        ];
    }
}
