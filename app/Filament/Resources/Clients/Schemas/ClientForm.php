<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Filament\Support\BranchSelect;
use App\Filament\Support\DistributorSelect;
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
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(DistributorSelect::searchResults(...))
                    ->getOptionLabelUsing(DistributorSelect::optionLabel(...))
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
