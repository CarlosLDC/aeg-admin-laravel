<?php

namespace App\Filament\Resources\Technicians\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechnicianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_center_id')
                    ->label('Centro de Servicio')
                    ->relationship('serviceCenter', 'id')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('national_id')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
            ]);
    }
}
