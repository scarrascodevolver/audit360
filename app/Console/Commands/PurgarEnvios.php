<?php

namespace App\Console\Commands;

use App\Models\Envio;
use App\Models\Solicitud;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PurgarEnvios extends Command
{
    protected $signature = 'envios:purgar';

    protected $description = 'RGPD: elimina envíos y solicitudes (BD y archivos) que superan los días de retención';

    public function handle(): int
    {
        $limite = now()->subDays(config('audit360.retencion_dias'));
        $purgados = 0;

        Envio::query()
            ->where('created_at', '<', $limite)
            ->each(function (Envio $envio) use (&$purgados): void {
                Storage::disk('envios')->deleteDirectory((string) $envio->id);
                $envio->delete();
                $purgados++;
            });

        // Las solicitudes no tienen archivos asociados, solo el registro.
        $solicitudes = Solicitud::query()
            ->where('created_at', '<', $limite)
            ->delete();

        $this->info("Envíos purgados: {$purgados}");
        $this->info("Solicitudes purgadas: {$solicitudes}");

        return self::SUCCESS;
    }
}
