<?php

namespace App\Filament\Resources\Solicitudes\Pages;

use App\Filament\Resources\Solicitudes\SolicitudResource;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudes extends ListRecords
{
    protected static string $resource = SolicitudResource::class;

    // Sin acciones de cabecera: las solicitudes solo entran desde la web.
}
