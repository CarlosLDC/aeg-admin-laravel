<?php

namespace App\Filament\Resources\Firmware\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FirmwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('version')
                    ->label('Versión')
                    ->required()
                    ->mask('9.9.9')
                    ->placeholder('1.0.0')
                    ->regex('/^\d\.\d\.\d$/'),
                DatePicker::make('release_date')
                    ->label('Fecha de Lanzamiento')
                    ->required(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
