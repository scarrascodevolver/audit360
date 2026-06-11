<?php

namespace App\Filament\Resources\Envios\Pages;

use App\Filament\Resources\Envios\EnvioResource;
use Filament\Resources\Pages\ListRecords;

class ListEnvios extends ListRecords
{
    protected static string $resource = EnvioResource::class;

    // Sin acciones de cabecera: los envíos solo se crean desde el
    // formulario público de la web, aquí únicamente se revisan.
}
