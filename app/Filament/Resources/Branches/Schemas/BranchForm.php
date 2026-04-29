<?php

namespace App\Filament\Resources\Branches\Schemas;

use App\Enums\VenezuelaState;
use App\Filament\Support\HintIconText;
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
                        Grid::make(2)
                            ->schema([
                                TextInput::make('tax_id')
                                    ->label('RIF')
                                    ->required()
                                    ->regex('/^[VEJGCP][0-9]{1,9}$/i')
                                    ->stripCharacters('-')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: HintIconText::taxId())
                                    ->placeholder('J123456789'),
                                TextInput::make('trade_name')
                                    ->label('Nombre Comercial')
                                    ->required()
                                    ->unique()
                                    ->placeholder('Sucursal Caracas'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Ubicación')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('state')
                                    ->label('Estado')
                                    ->required()
                                    ->options(VenezuelaState::class)
                                    ->searchable(),
                                TextInput::make('city')
                                    ->label('Ciudad')
                                    ->required()
                                    ->placeholder('Caracas'),
                            ]),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->required()
                            ->placeholder('Av. Principal, edificio, piso y referencia'),
                    ])
                    ->columnSpanFull(),
                Section::make('Contacto')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone_primary')
                                    ->label('Teléfono Principal')
                                    ->required()
                                    ->tel()
                                    ->placeholder('+5802125550000'),
                                TextInput::make('phone_secondary')
                                    ->label('Teléfono Secundario')
                                    ->tel()
                                    ->placeholder('+5802125550001'),
                                TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->required()
                                    ->email()
                                    ->placeholder('contacto@empresa.com'),
                                TextInput::make('contact_person')
                                    ->label('Persona de Contacto')
                                    ->required()
                                    ->placeholder('Nombre y apellido'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
