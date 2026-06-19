<?php

use App\Models\Contenido;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Quita el override antiguo del párrafo del hero guardado en el CMS para que
     * la web muestre el texto por defecto del código:
     * "Por solo 100 €, envíanos tu solicitud y en menos de 24 horas recibirás
     *  un informe claro con todas las mejoras que podemos aplicar en tu comunidad."
     * Es idempotente: si ya no existe, no hace nada.
     */
    public function up(): void
    {
        // delete() en el modelo dispara la invalidación de caché (hook booted()).
        Contenido::where('clave', 'hero.parrafo')->delete();
        Cache::forget(Contenido::CACHE_KEY);
    }

    public function down(): void
    {
        // No se restaura el texto anterior.
    }
};
