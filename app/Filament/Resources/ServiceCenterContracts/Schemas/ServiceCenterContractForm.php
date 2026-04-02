<?php

namespace App\Filament\Resources\ServiceCenterContracts\Schemas;

use App\Models\ServiceCenter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceCenterContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_center_id')
                    ->label('Centro de Servicio')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => ServiceCenter::query()
                        ->join('branches', 'service_centers.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("service_centers.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->whereAny(['companies.legal_name', 'companies.tax_id', 'branches.trade_name'], 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('label', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn(string $value): ?string => ServiceCenter::query()
                        ->join('branches', 'service_centers.branch_id', '=', 'branches.id')
                        ->join('companies', 'branches.company_id', '=', 'companies.id')
                        ->selectRaw("service_centers.id, branches.trade_name || ' (' || companies.tax_id || ')' as label")
                        ->where('service_centers.id', $value)
                        ->value('label'))
                    ->searchPrompt('Buscar por Nombre Comercial, Razón Social o RIF...'),
                TextInput::make('photo_path')
                    ->label('Ruta de la foto del contrato')
                    ->required()
                    ->url()
                    ->placeholder('http://example.com/contrato.jpg')
                    ->columnSpanFull()
                    ->copyable()
                    ->validationMessages([
                        'url' => 'Ingrese una URL válida.',
                    ]),
                DatePicker::make('start_date')
                    ->label('Fecha de inicio')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Fecha de finalización')
                    ->required()
                    ->after('start_date')
                    ->validationMessages([
                        'after' => 'La fecha de finalización debe ser posterior a la fecha de inicio.',
                    ]),
            ]);
    }
}
