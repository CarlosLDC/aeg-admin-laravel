<?php

namespace App\Filament\Schemas;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class SoftwareSchemas
{
    public static function form(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required(),
            TextInput::make('version')
                ->label('Versión')
                ->required(),
            DatePicker::make('integration_date')
                ->label('Fecha de Integración')
                ->required(),
            Select::make('operating_systems')
                ->label('Sistemas Operativos Compatibles')
                ->required()
                ->multiple()
                ->options(OperatingSystem::class),
            Select::make('programming_languages')
                ->label('Lenguajes de Programación')
                ->required()
                ->multiple()
                ->options(ProgrammingLanguage::class),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),
            TextColumn::make('version')
                ->label('Versión')
                ->searchable(),
            TextColumn::make('integration_date')
                ->label('Fecha de Integración')
                ->date()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
