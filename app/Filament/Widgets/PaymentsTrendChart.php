<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class PaymentsTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tendencia de cobros (6 meses)';

    protected ?string $description = 'Evolución mensual del total cobrado para una lectura rápida del flujo.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'lg' => 12,
        '2xl' => 4,
    ];

    protected function getData(): array
    {
        $end = CarbonImmutable::now()->endOfMonth();
        $start = $end->subMonths(5)->startOfMonth();

        $payments = Payment::query()
            ->whereBetween('paid_at', [$start, $end])
            ->get(['paid_at', 'total_amount']);

        $period = CarbonPeriod::create($start, '1 month', $end);
        $labels = [];
        $values = [];

        foreach ($period as $month) {
            $monthLabel = $month->locale('es')->translatedFormat('M y');

            $total = $payments
                ->filter(fn (Payment $payment): bool => $payment->paid_at?->format('Y-m') === $month->format('Y-m'))
                ->sum(fn (Payment $payment): float => (float) $payment->total_amount);

            $labels[] = ucfirst($monthLabel);
            $values[] = round($total, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cobros ($)',
                    'data' => $values,
                    'fill' => true,
                    'tension' => 0.35,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.12)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
