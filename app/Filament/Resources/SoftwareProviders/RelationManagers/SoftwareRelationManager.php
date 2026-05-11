<?php

namespace App\Filament\Resources\SoftwareProviders\RelationManagers;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
use App\Filament\Resources\Software\SoftwareResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SoftwareRelationManager extends RelationManager
{
    protected static string $relationship = 'software';

    protected static ?string $relatedResource = SoftwareResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Software')
                    ->tabs([
                        Tab::make('General')
                            ->components([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nombre')
                                            ->required()
                                            ->placeholder('Nombre del Software'),
                                        TextInput::make('version')
                                            ->label('Versión')
                                            ->required()
                                            ->placeholder('Versión del Software'),
                                        DatePicker::make('integration_date')
                                            ->label('Fecha de Integración'),
                                    ]),
                            ]),
                        Tab::make('Detalles Técnicos')
                            ->components([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('operating_systems')
                                            ->label('Sistemas Operativos Compatibles')
                                            ->multiple()
                                            ->options(OperatingSystem::class),
                                        Select::make('programming_languages')
                                            ->label('Lenguajes de Programación')
                                            ->multiple()
                                            ->options(ProgrammingLanguage::class),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('version')
                    ->label('Versión')
                    ->searchable(),
                TextColumn::make('integration_date')
                    ->label('Fecha de Integración')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modal(),
            ]);
    }
}
