<?php

use App\Filament\Pages\Ajustes;
use App\Filament\Resources\Envios\Pages\ViewEnvio;
use App\Models\Ajuste;
use App\Models\Envio;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('exige login para entrar al panel de administración', function () {
    $this->get('/admin')->assertRedirect();
    $this->get('/admin/envios')->assertRedirect();
});

it('muestra el listado de envíos a un admin autenticado', function () {
    Envio::create([
        'telefono' => '600999888',
        'email' => 'panel@example.com',
        'consentimiento_at' => now(),
    ]);

    $this->actingAs(User::factory()->create())
        ->get('/admin/envios')
        ->assertOk()
        ->assertSee('600999888');
});

it('guarda el correo de avisos y el adjuntar desde la página de Ajustes', function () {
    Cache::flush();

    Livewire::actingAs(User::factory()->create())
        ->test(Ajustes::class)
        ->assertOk()
        ->fillForm([
            'email_notificaciones' => ['administracion@nexofincas.es', 'gestor@nexofincas.es'],
            'adjuntar_archivos' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Ajuste::get(Ajuste::EMAIL_NOTIFICACIONES))->toBe('administracion@nexofincas.es,gestor@nexofincas.es')
        ->and(Ajuste::emailsNotificaciones())->toBe(['administracion@nexofincas.es', 'gestor@nexofincas.es'])
        ->and(Ajuste::bool(Ajuste::ADJUNTAR_ARCHIVOS, true))->toBeFalse();
});

it('descarga todos los documentos de un envío en un único zip descifrado', function () {
    Storage::fake('envios');

    $envio = Envio::create([
        'telefono' => '600777666',
        'email' => 'zip@example.com',
        'consentimiento_at' => now(),
    ]);
    foreach (['acta.pdf', 'presupuesto.pdf'] as $i => $nombre) {
        $ruta = $envio->id.'/doc'.$i.'.bin';
        Storage::disk('envios')->put($ruta, encrypt('contenido '.$nombre));
        $envio->documentos()->create([
            'slot' => 'actas',
            'nombre_original' => $nombre,
            'ruta' => $ruta,
            'tamano_bytes' => 10,
            'mime' => 'application/pdf',
        ]);
    }

    Livewire::actingAs(User::factory()->create())
        ->test(ViewEnvio::class, ['record' => $envio->getRouteKey()])
        ->callAction('descargarTodo')
        ->assertFileDownloaded('envio-'.$envio->id.'-600777666.zip');
});
