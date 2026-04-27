<?php

namespace App\Filament\Schemas;

use App\Filament\Support\SearchPromptText;
use App\Models\Branch;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;

class BranchSpecializationSchemas
{
    public static function form(): array
    {
        return [
            Select::make('branch_id')
                ->label('Sucursal')
                ->required()
                ->unique()
                ->searchable()
                ->getSearchResultsUsing(
                    fn (string $search): array => Branch::query()
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->where(function ($query) use ($search): void {
                            $query->whereLike('branches.trade_name', "%{$search}%")
                                ->orWhereLike('companies.tax_id', "%{$search}%")
                                ->orWhereLike('companies.legal_name', "%{$search}%");
                        })
                        ->limit(50)
                        ->pluck('branches.trade_name', 'branches.id')
                        ->all()
                )
                ->getOptionLabelUsing(
                    fn (mixed $value): ?string => Branch::query()
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->where('branches.id', $value)
                        ->value('branches.trade_name')
                )
                ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId()),
        ];
    }

    public static function infolist(): array
    {
        return [
            TextEntry::make('branch.trade_name')
                ->label('Nombre Comercial'),
            TextEntry::make('branch.company.tax_id')
                ->label('RIF'),
            TextEntry::make('branch.state')
                ->label('Estado'),
            TextEntry::make('branch.city')
                ->label('Ciudad'),
            TextEntry::make('branch.phone_primary')
                ->label('Teléfono Principal'),
            TextEntry::make('branch.phone_secondary')
                ->label('Teléfono Secundario')
                ->placeholder('-'),
            TextEntry::make('branch.email')
                ->label('Correo Electrónico'),
            TextEntry::make('branch.contact_person')
                ->label('Persona de Contacto'),
        ];
    }

    public static function table(): array
    {
        return [
            TextColumn::make('branch.trade_name')
                ->label('Nombre Comercial')
                ->searchable(),
            TextColumn::make('branch.company.tax_id')
                ->label('RIF')
                ->searchable(),
            TextColumn::make('branch.state')
                ->label('Estado')
                ->searchable(),
            TextColumn::make('branch.city')
                ->label('Ciudad')
                ->searchable(),
            TextColumn::make('branch.phone_primary')
                ->label('Teléfono Principal')
                ->searchable(),
            TextColumn::make('branch.phone_secondary')
                ->label('Teléfono Secundario')
                ->searchable(),
            TextColumn::make('branch.email')
                ->label('Correo Electrónico')
                ->searchable(),
            TextColumn::make('branch.contact_person')
                ->label('Persona de Contacto')
                ->searchable(),
        ];
    }
}
