<?php

namespace App\Filament\Resources\Technicians\Schemas;

use App\Models\ServiceCenter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechnicianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_center_id')
                    ->label('Centro de Servicio')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => ServiceCenter::query()
                        ->join('branches', 'service_centers.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("service_centers.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('label', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn (string $value): ?string => ServiceCenter::query()
                        ->join('branches', 'service_centers.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("service_centers.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->where('service_centers.id', $value)
                        ->value('label'))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('national_id')
                    ->label('Cédula')
                    ->required()
                    ->unique()
                    ->regex('/^[VE][0-9]{7,8}$/')
                    ->validationMessages([
                        'regex' => 'La cédula debe comenzar con V o E (en mayúsculas) seguido de 7 u 8 dígitos, sin espacios ni separadores (ejemplo: V12345678).',
                    ]),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
            ]);
    }
}
