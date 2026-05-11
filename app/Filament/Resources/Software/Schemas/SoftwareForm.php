<?php

namespace App\Filament\Resources\Software\Schemas;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
use App\Models\SoftwareProvider;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Software')
                    ->tabs([
                        Tab::make('General')
                            ->components([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('software_provider_id')
                                            ->label('Casa de Software')
                                            ->required()
                                            ->searchable()
                                            ->getSearchResultsUsing(
                                                fn (string $search): array => SoftwareProvider::query()
                                                    ->join('branches', 'branches.id', '=', 'software_providers.branch_id')
                                                    ->where('branches.trade_name', 'like', "%{$search}%")
                                                    ->limit(50)
                                                    ->pluck('branches.trade_name', 'software_providers.id')
                                                    ->all()
                                            )
                                            ->getOptionLabelUsing(
                                                fn (mixed $value): ?string => SoftwareProvider::query()
                                                    ->join('branches', 'branches.id', '=', 'software_providers.branch_id')
                                                    ->where('software_providers.id', $value)
                                                    ->value('branches.trade_name')
                                            ),
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
}
