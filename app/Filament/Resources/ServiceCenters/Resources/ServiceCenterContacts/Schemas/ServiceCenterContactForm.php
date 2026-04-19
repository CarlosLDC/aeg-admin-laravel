<?php

namespace App\Filament\Resources\ServiceCenters\Resources\ServiceCenterContacts\Schemas;

use App\Filament\Support\HintIconText;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceCenterContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('national_id')
                    ->label('Cédula')
                    ->placeholder('V12345678')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: HintIconText::nationalId())
                    ->required()
                    ->unique()
                    ->regex('/^[VE][0-9]{7,8}$/'),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
            ]);
    }
}
