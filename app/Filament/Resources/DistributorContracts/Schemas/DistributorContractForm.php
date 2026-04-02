<?php

namespace App\Filament\Resources\DistributorContracts\Schemas;

use App\Models\Distributor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistributorContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('distributor_id')
                    ->label('Distribuidor')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("distributors.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('label', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn(string $value): ?string => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->where('distributors.id', $value)
                        ->value('label'))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                TextInput::make('photo_path')
                    ->label('Ruta de la foto del contrato')
                    ->placeholder('http://example.com/contrato.jpg')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Fecha de inicio')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Fecha de finalización')
                    ->required(),
            ]);
    }
}
