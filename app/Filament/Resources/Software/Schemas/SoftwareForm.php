<?php

namespace App\Filament\Resources\Software\Schemas;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('software_provider_id')
                    ->label('Proveedor')
                    ->required()
                    ->relationship('softwareProvider', 'name')
                    ->searchable(['name', 'tax_id'])
                    ->preload()
                    ->searchPrompt('Buscar Proveedor de Software por nombre o RIF...'),
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
            ]);
    }
}
