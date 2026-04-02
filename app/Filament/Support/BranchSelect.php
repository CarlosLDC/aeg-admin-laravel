<?php

namespace App\Filament\Support;

use App\Models\Branch;

final class BranchSelect
{
    public static function searchResults(string $search): array
    {
        return Branch::query()
            ->join('companies', 'branches.company_id', '=', 'companies.id')
            ->selectRaw("branches.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
            ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
            ->limit(50)
            ->pluck('label', 'id')
            ->all();
    }

    public static function optionLabel(mixed $value): ?string
    {
        return Branch::query()
            ->join('companies', 'branches.company_id', '=', 'companies.id')
            ->selectRaw("branches.trade_name || ' (' || companies.tax_id || ')' as label")
            ->where('branches.id', $value)
            ->value('label');
    }
}
