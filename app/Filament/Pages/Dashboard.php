<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Envios\EnvioResource;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // No mostramos Escritorio: no aparece en el menú y al entrar en /admin
    // se redirige directo a la lista de Envíos.
    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(EnvioResource::getUrl());
    }
}
