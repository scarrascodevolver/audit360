<?php

namespace App\Filament\Resources\Contenidos\Pages;

use App\Filament\Resources\Contenidos\ContenidoResource;
use Filament\Resources\Pages\EditRecord;

class EditContenido extends EditRecord
{
    protected static string $resource = ContenidoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
