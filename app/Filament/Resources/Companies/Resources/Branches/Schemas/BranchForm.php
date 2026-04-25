<?php

namespace App\Filament\Resources\Companies\Resources\Branches\Schemas;

use App\Enums\VenezuelaState;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->schema([
                        TextInput::make('trade_name')
                            ->label('Nombre Comercial')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Section::make('Ubicación')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('state')
                                    ->label('Estado')
                                    ->required()
                                    ->options(VenezuelaState::class)
                                    ->searchable(),
                                TextInput::make('city')
                                    ->label('Ciudad')
                                    ->required(),
                            ]),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Section::make('Contacto')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('phone_primary')
                                    ->label('Teléfono Principal')
                                    ->required()
                                    ->tel(),
                                TextInput::make('phone_secondary')
                                    ->label('Teléfono Secundario')
                                    ->tel(),
                                TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->required()
                                    ->email(),
                                TextInput::make('contact_person')
                                    ->label('Persona de Contacto')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
