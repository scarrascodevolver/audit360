<?php

namespace App\Filament\Resources\Solicitudes\Pages;

use App\Filament\Resources\Solicitudes\SolicitudResource;
use App\Models\Solicitud;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewSolicitud extends ViewRecord
{
    protected static string $resource = SolicitudResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('marcarContactada')
                ->label('Marcar como contactada')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->visible(fn (): bool => $this->record->estado === Solicitud::ESTADO_NUEVA)
                ->action(function (): void {
                    $this->record->update(['estado' => Solicitud::ESTADO_CONTACTADA]);

                    Notification::make()
                        ->title('Solicitud marcada como contactada')
                        ->success()
                        ->send();
                }),
        ];
    }
}
