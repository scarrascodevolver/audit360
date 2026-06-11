<?php

namespace App\Filament\Resources\Envios\Pages;

use App\Filament\Resources\Envios\EnvioResource;
use App\Models\Envio;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewEnvio extends ViewRecord
{
    protected static string $resource = EnvioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('marcarRevisado')
                ->label('Marcar como revisado')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->visible(fn (): bool => $this->record->estado === Envio::ESTADO_NUEVO)
                ->action(function (): void {
                    $this->record->update(['estado' => Envio::ESTADO_REVISADO]);

                    Notification::make()
                        ->title('Envío marcado como revisado')
                        ->success()
                        ->send();
                }),
        ];
    }
}
