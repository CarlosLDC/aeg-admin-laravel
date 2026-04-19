<?php

namespace App\Filament\Resources\Software\Schemas;

use App\Filament\Schemas\SoftwareSchemas;
use App\Filament\Support\SearchPromptText;
use App\Models\SoftwareProvider;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SoftwareForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('software_provider_id')
                    ->label('Proveedor')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn (string $search): array => SoftwareProvider::query()
                            ->join('branches', 'software_providers.branch_id', '=', 'branches.id')
                            ->join('companies', 'branches.company_id', '=', 'companies.id')
                            ->where(function ($query) use ($search): void {
                                $query->whereLike('branches.trade_name', "%{$search}%")
                                    ->orWhereLike('companies.tax_id', "%{$search}%")
                                    ->orWhereLike('companies.legal_name', "%{$search}%");
                            })
                            ->where()
                            ->limit(50)
                            ->pluck('branches.trade_name', 'software_providers.id')
                            ->all()
                    )
                    ->getOptionLabelUsing(
                        fn (mixed $value): ?string => SoftwareProvider::query()
                            ->join('branches', 'software_providers.branch_id', '=', 'branches.id')
                            ->join('companies', 'branches.company_id', '=', 'companies.id')
                            ->where('software_providers.id', $value)
                            ->value('branches.trade_name')
                    )
                    ->preload()
                    ->searchPrompt(SearchPromptText::branchCompanyTaxIdWithEllipsis()),
                ...SoftwareSchemas::form(),
            ]);
    }
}
