<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRoles;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo')
                    ->required()
                    ->email(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->required()
                    ->password(),
                Select::make('roles')
                    ->label('Rol')
                    ->required()
                    ->relationship('roles', 'name')
                    ->preload(),
            ]);
    }
}
