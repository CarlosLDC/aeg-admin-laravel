<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Purchase;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = [
        'md' => 1,
        'lg' => 12,
        '2xl' => 8,
    ];

    protected int|array|null $columns = [
        'md' => 2,
        'xl' => 2,
        '2xl' => 2,
    ];

    protected function getStats(): array
    {
        $monthStart = CarbonImmutable::now()->startOfMonth();
        $monthEnd = CarbonImmutable::now()->endOfMonth();

        $purchasesTotal = (float) Purchase::query()->sum('total');

        $paymentsThisMonth = (float) Payment::query()
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('total_amount');

        return [
            Stat::make('Compras acumuladas', '$'.number_format($purchasesTotal, 2, ',', '.'))
                ->description('Total histórico')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Cobros del mes', '$'.number_format($paymentsThisMonth, 2, ',', '.'))
                ->description('Mes actual')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
