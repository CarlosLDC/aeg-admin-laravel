<?php

namespace App\Filament\Resources\Clients\Schemas;

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
                    ->relationship('branch', 'trade_name')
                    ->searchable()
                    ->validationMessages([
                        'unique' => 'Esta sucursal ya está registrada como cliente.',
                    ]),
                Select::make('distributor_id')
                    ->label('Distribuidor')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->where('branches.trade_name', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('branches.trade_name', 'distributors.id')
                        ->all())
                    ->getOptionLabelUsing(fn(string $value): ?string => Distributor::query()
                        ->join('branches', 'distributors.branch_id', '=', 'branches.id')
                        ->where('distributors.id', $value)
                        ->value('branches.trade_name'))
                    ->rules([
                        fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get): void {
                            if (blank($value) || blank($get('branch_id'))) {
                                return;
                            }

                            $distributorBranchId = Distributor::query()
                                ->whereKey($value)
                                ->value('branch_id');

                            if ((string) $distributorBranchId === (string) $get('branch_id')) {
                                $fail('Un cliente no puede ser su propio distribuidor.');
                            }
                        },
                    ])
            ]);
    }
}
