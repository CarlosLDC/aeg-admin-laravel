<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Filament\Support\BranchSelect;
use App\Models\Distributor;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label('Sucursal')
                    ->required()
                    ->unique()
                    ->searchable()
                    ->getSearchResultsUsing(BranchSelect::searchResults(...))
                    ->getOptionLabelUsing(BranchSelect::optionLabel(...))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...')
                    ->validationMessages([
                        'unique' => 'Esta sucursal ya está registrada como cliente.',
                    ]),
                Select::make('distributor_id')
                    ->label('Distribuidora')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("distributors.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('label', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn (string $value): ?string => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->where('distributors.id', $value)
                        ->value('label'))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...')
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get): void {
                            if (blank($value) || blank($get('branch_id'))) {
                                return;
                            }

                            $distributorBranchId = Distributor::query()
                                ->whereKey($value)
                                ->value('branch_id');

                            if ((string) $distributorBranchId === (string) $get('branch_id')) {
                                $fail('Un cliente no puede ser su propia distribuidora.');
                            }
                        },
                    ]),
            ]);
    }
}
