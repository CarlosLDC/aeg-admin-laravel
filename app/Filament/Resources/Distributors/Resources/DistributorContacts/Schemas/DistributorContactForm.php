<?php

namespace App\Filament\Resources\Distributors\Resources\DistributorContacts\Schemas;

use App\Filament\Support\HintIconText;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistributorContactForm
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
                    ->required()
                    ->unique()
                    ->regex('/^[VE][0-9]{1,8}$/i')
                    ->stripCharacters('-')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: HintIconText::nationalId()),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->required()
                    ->tel(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->required()
                    ->email(),
            ]);
    }
}
