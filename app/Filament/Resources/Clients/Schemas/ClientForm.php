<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Filament\Schemas\BranchSpecializationSchemas;
use App\Filament\Support\DistributorSelect;
use App\Filament\Support\SearchPromptText;
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
                ...BranchSpecializationSchemas::form(),
                Select::make('distributor_id')
                    ->label('Distribuidora')
                    ->searchable()
                    ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                    ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
                    ->searchPrompt(SearchPromptText::tradeNameLegalNameOrTaxId())
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
