<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\QuickActions;
use App\Filament\Widgets\RecentPurchases;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Panel de Control';

    protected ?string $subheading = 'Resumen operativo y accesos clave para gestionar el negocio.';

    public function getWidgets(): array
    {
        return [
            QuickActions::class,
            DashboardOverview::class,
            RecentPurchases::class,
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
