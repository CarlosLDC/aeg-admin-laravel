<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\RecentSales;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Panel de Control';

    protected ?string $subheading = 'Resumen operativo y accesos clave para gestionar el negocio.';

    public function getWidgets(): array
    {
        return [
            DashboardOverview::class,
            RecentSales::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 1,
            'lg' => 12,
            'xl' => 12,
        ];
    }
}
