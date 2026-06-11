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
