<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('contractable_type')
                    ->required(),
                TextInput::make('contractable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('photo_path')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
            ]);
    }
}
