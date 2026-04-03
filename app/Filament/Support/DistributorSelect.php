<?php

namespace App\Filament\Support;

use App\Models\Distributor;

final class DistributorSelect
{
    public static function searchResults(string $search): array
    {
        return Distributor::query()
            ->join('branches', 'distributors.branch_id', '=', 'branches.id')
            ->join('companies', 'branches.company_id', '=', 'companies.id')
            ->selectRaw("distributors.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
            ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
            ->limit(50)
            ->pluck('label', 'id')
            ->all();
    }

    public static function optionLabel(string $value): ?string
    {
        return Distributor::query()
            ->join('branches', 'distributors.branch_id', '=', 'branches.id')
            ->join('companies', 'branches.company_id', '=', 'companies.id')
            ->selectRaw("branches.trade_name || ' (' || companies.tax_id || ')' as label")
            ->where('distributors.id', $value)
            ->value('label');
    }
}
