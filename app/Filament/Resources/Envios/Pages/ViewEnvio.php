<?php

namespace App\Filament\Resources\Envios\Pages;

use App\Filament\Resources\Envios\EnvioResource;
use App\Models\Envio;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ViewEnvio extends ViewRecord
{
    protected static string $resource = EnvioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargarTodo')
                ->label('Descargar todo (ZIP)')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->visible(fn (): bool => $this->record->documentos()->exists())
                ->action(fn (): BinaryFileResponse => $this->descargarZip()),
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

    /** Todos los documentos del envío, descifrados, en un único ZIP. */
    private function descargarZip(): BinaryFileResponse
    {
        $rutaZip = tempnam(sys_get_temp_dir(), 'envio-zip-');

        $zip = new ZipArchive;
        $zip->open($rutaZip, ZipArchive::OVERWRITE);

        foreach ($this->record->documentos as $i => $documento) {
            // Prefijo con apartado e índice: evita colisiones de nombre.
            $nombre = sprintf('%02d-%s-%s', $i + 1, $documento->slot, $documento->nombre_original);
            $zip->addFromString($nombre, Crypt::decrypt(Storage::disk('envios')->get($documento->ruta)));
        }

        $zip->close();

        $nombreZip = sprintf(
            'envio-%d-%s.zip',
            $this->record->id,
            Str::slug($this->record->telefono ?: $this->record->email ?: (string) $this->record->id),
        );

        return response()->download($rutaZip, $nombreZip)->deleteFileAfterSend();
    }
}
