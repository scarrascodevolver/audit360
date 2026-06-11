<?php

use App\Models\Envio;
use App\Models\User;

it('exige login para entrar al panel de administración', function () {
    $this->get('/admin')->assertRedirect();
    $this->get('/admin/envios')->assertRedirect();
});

it('muestra el listado de envíos a un admin autenticado', function () {
    $envio = Envio::create([
        'comunidad' => 'Comunidad Panel',
        'telefono' => '600999888',
        'email' => 'panel@example.com',
        'consentimiento_at' => now(),
    ]);

    $this->actingAs(User::factory()->create())
        ->get('/admin/envios')
        ->assertOk()
        ->assertSee('Comunidad Panel');
});

it('descarga todos los documentos de un envío en un único zip descifrado', function () {
    \Illuminate\Support\Facades\Storage::fake('envios');

    $envio = Envio::create([
        'comunidad' => 'Comunidad Zip',
        'telefono' => '600777666',
        'email' => 'zip@example.com',
        'consentimiento_at' => now(),
    ]);
    foreach (['acta.pdf', 'presupuesto.pdf'] as $i => $nombre) {
        $ruta = $envio->id.'/doc'.$i.'.bin';
        \Illuminate\Support\Facades\Storage::disk('envios')->put($ruta, encrypt('contenido '.$nombre));
        $envio->documentos()->create([
            'slot' => 'actas',
            'nombre_original' => $nombre,
            'ruta' => $ruta,
            'tamano_bytes' => 10,
            'mime' => 'application/pdf',
        ]);
    }

    \Livewire\Livewire::actingAs(User::factory()->create())
        ->test(\App\Filament\Resources\Envios\Pages\ViewEnvio::class, ['record' => $envio->getRouteKey()])
        ->callAction('descargarTodo')
        ->assertFileDownloaded('envio-'.$envio->id.'-comunidad-zip.zip');
});

