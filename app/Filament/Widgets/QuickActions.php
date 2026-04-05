<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Route;

class QuickActions extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Acciones rápidas';

    protected ?string $description = 'Atajos para las operaciones más frecuentes del panel.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return array_values(array_filter([
            $this->makeActionStat(
                label: 'Nueva compra',
                description: 'Registrar factura',
                icon: 'heroicon-m-document-plus',
                color: 'primary',
                url: $this->safeNamedRoute(
                    preferredRouteName: 'filament.admin.resources.purchases.create',
                    fallbackRouteName: 'filament.admin.resources.purchases.index',
                ),
            ),
            $this->makeActionStat(
                label: 'Nueva impresora',
                description: 'Agregar equipo',
                icon: 'heroicon-m-printer',
                color: 'success',
                url: $this->safeNamedRoute(
                    preferredRouteName: 'filament.admin.resources.impresoras.create',
                    fallbackRouteName: 'filament.admin.resources.impresoras.index',
                ),
            ),
            $this->makeActionStat(
                label: 'Clientes',
                description: 'Ir al listado',
                icon: 'heroicon-m-users',
                color: 'gray',
                url: $this->safeNamedRoute(
                    preferredRouteName: 'filament.admin.resources.clients.index',
                    fallbackRouteName: 'filament.admin.pages.dashboard',
                ),
            ),
        ]));
    }

    /**
     * @param  'danger'|'gray'|'info'|'primary'|'success'|'warning'  $color
     */
    private function makeActionStat(string $label, string $description, string $icon, string $color, ?string $url): ?Stat
    {
        if (! $url) {
            return null;
        }

        return Stat::make($label, 'Abrir')
            ->description($description)
            ->descriptionIcon($icon)
            ->url($url)
            ->color($color);
    }

    private function safeNamedRoute(string $preferredRouteName, string $fallbackRouteName): ?string
    {
        if (Route::has($preferredRouteName)) {
            return route($preferredRouteName);
        }

        if (Route::has($fallbackRouteName)) {
            return route($fallbackRouteName);
        }

        return null;
    }
}
