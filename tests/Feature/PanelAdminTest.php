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

it('muestra los textos del sitio a un admin autenticado', function () {
    $this->seed(\Database\Seeders\ContenidoSeeder::class);

    $this->actingAs(User::factory()->create())
        ->get('/admin/contenidos')
        ->assertOk()
        ->assertSee('Eslogan superior');
});

it('muestra la edición de un texto con su vista previa', function () {
    $this->seed(\Database\Seeders\ContenidoSeeder::class);
    $contenido = \App\Models\Contenido::where('clave', 'cuota.titulo_teal')->firstOrFail();

    $this->actingAs(User::factory()->create())
        ->get("/admin/contenidos/{$contenido->id}/edit")
        ->assertOk()
        ->assertSee('Vista previa')
        ->assertSee('/cuota-segura');
});
