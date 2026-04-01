<?php

namespace App\Filament\Resources\Software\Schemas;

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
                    ->label('Proveedor de Software')
                    ->required()
                    ->relationship('softwareProvider', 'name')
                    ->searchable(['name', 'tax_id'])
                    ->preload()
                    ->searchPrompt('Buscar Proveedor de Software por nombre o RIF...'),
                TextInput::make('name')
                    ->label('Nombre del Software')
                    ->required(),
                TextInput::make('version')
                    ->label('Versión')
                    ->required(),
                DatePicker::make('integration_date')
                    ->label('Fecha de Integración')
                    ->required(),
            ]);
    }
}
