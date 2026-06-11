<?php

namespace App\Filament\Widgets;

use App\Models\Envio;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstadisticasEnvios extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Envíos pendientes de revisar', Envio::where('estado', Envio::ESTADO_NUEVO)->count())
                ->description('Documentación recibida sin revisar')
                ->color('warning'),
            Stat::make('Envíos este mes', Envio::whereBetween('created_at', [now()->startOfMonth(), now()])->count())
                ->description('Total recibidos desde el día 1')
                ->color('success'),
            Stat::make('Envíos totales', Envio::count())
                ->description('Se borran a los '.config('audit360.retencion_dias').' días (RGPD)')
                ->color('info'),
        ];
    }
}
