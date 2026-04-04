<?php

namespace App\Filament\Resources\Companies\Resources\Branches\Schemas;

use App\Enums\VenezuelaState;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trade_name')
                    ->label('Nombre Comercial')
                    ->required(),
                Grid::make()
                    ->schema([
                        Select::make('state')
                            ->label('Estado')
                            ->options(VenezuelaState::class)
                            ->required()
                            ->searchable(),
                        TextInput::make('city')
                            ->label('Ciudad')
                            ->required(),
                    ])->columnSpanFull(),
                Textarea::make('address')
                    ->label('Dirección')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->label('Número de Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
                TextInput::make('contact_person')
                    ->label('Persona de Contacto')
                    ->required(),
            ]);
    }
}
