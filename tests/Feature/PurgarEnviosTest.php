<?php

use App\Models\Envio;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\artisan;

it('purga los envíos que superan la retención, con BD y archivos, y respeta los recientes', function () {
    Storage::fake('envios');

    $viejo = Envio::create([
        'telefono' => '600000001',
        'email' => 'viejo@example.com',
        'consentimiento_at' => now()->subDays(31),
    ]);
    $viejo->created_at = now()->subDays(31);
    $viejo->save();
    $viejo->documentos()->create([
        'slot' => 'actas',
        'nombre_original' => 'acta.pdf',
        'ruta' => $viejo->id.'/acta.bin',
        'tamano_bytes' => 10,
        'mime' => 'application/pdf',
    ]);
    Storage::disk('envios')->put($viejo->id.'/acta.bin', 'cifrado');

    $reciente = Envio::create([
        'telefono' => '600000002',
        'email' => 'reciente@example.com',
        'consentimiento_at' => now(),
    ]);

    artisan('envios:purgar')->assertSuccessful();

    expect(Envio::find($viejo->id))->toBeNull()
        ->and($viejo->documentos()->count())->toBe(0)
        ->and(Storage::disk('envios')->exists($viejo->id.'/acta.bin'))->toBeFalse()
        ->and(Envio::find($reciente->id))->not->toBeNull();
});
