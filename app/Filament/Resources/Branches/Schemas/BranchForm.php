<?php

namespace App\Filament\Resources\Branches\Schemas;

use App\Enums\VenezuelaState;
use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label('Empresa')
                    ->required()
                    ->relationship('company', 'legal_name')
                    ->searchable(),
                TextInput::make('trade_name')
                    ->label('Nombre comercial')
                    ->required(),
                Select::make('state')
                    ->label('Estado')
                    ->required()
                    ->searchable()
                    ->options(VenezuelaState::class),
                TextInput::make('city')
                    ->label('Ciudad')
                    ->required(),
                Textarea::make('address')
                    ->label('Dirección')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required(),
                TextInput::make('contact_person')
                    ->label('Persona de contacto')
                    ->required(),
            ]);
    }
}
