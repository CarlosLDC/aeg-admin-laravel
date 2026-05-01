<?php

namespace App\Filament\Resources\Branches\Schemas;

use App\Enums\BranchRoles;
use App\Enums\TaxpayerType;
use App\Enums\VenezuelaState;
use App\Filament\Support\HintIconText;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('branch_form_tabs')
                    ->schema([
                        Tab::make('Información Fiscal')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('tax_id')
                                            ->label('RIF')
                                            ->required()
                                            ->regex('/^[VEJGCP][0-9]{1,9}$/i')
                                            ->stripCharacters('-')
                                            ->hintIcon(
                                                icon: 'heroicon-m-question-mark-circle',
                                                tooltip: HintIconText::taxId()
                                            )
                                            ->placeholder('J123456789'),
                                        TextInput::make('legal_name')
                                            ->label('Razón Social')
                                            ->required()
                                            ->unique()
                                            ->placeholder('Alpha Engineer Group, C.A.'),
                                        ToggleButtons::make('taxpayer_type')
                                            ->label('Tipo de Contribuyente')
                                            ->required()
                                            ->options(TaxpayerType::class)
                                            ->default(TaxpayerType::Ordinary->value)
                                            ->inline()
                                            ->columnSpanFull(),
                                        Select::make('state')
                                            ->label('Estado')
                                            ->required()
                                            ->options(VenezuelaState::class)
                                            ->searchable(),
                                        TextInput::make('city')
                                            ->label('Ciudad')
                                            ->required()
                                            ->placeholder('Caracas'),
                                        Textarea::make('address')
                                            ->label('Dirección')
                                            ->required()
                                            ->placeholder('Av. Principal, edificio, piso y referencia')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Información General')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('trade_name')
                                            ->label('Nombre Comercial')
                                            ->placeholder('AEG Caracas'),
                                        ToggleButtons::make('roles')
                                            ->label('Roles')
                                            ->multiple()
                                            ->options(BranchRoles::class)
                                            ->inline()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Contacto')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('phone_primary')
                                            ->label('Teléfono Principal')
                                            ->tel()
                                            ->placeholder('+5802125550000'),
                                        TextInput::make('phone_secondary')
                                            ->label('Teléfono Secundario')
                                            ->tel()
                                            ->placeholder('+5802125550001'),
                                        TextInput::make('email')
                                            ->label('Correo Electrónico')
                                            ->email()
                                            ->placeholder('contacto@empresa.com'),
                                        TextInput::make('contact_person')
                                            ->label('Persona de Contacto')
                                            ->placeholder('Nombre y Apellido'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
