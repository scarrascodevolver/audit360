<?php

use App\Models\Contenido;
use Database\Seeders\ContenidoSeeder;

it('devuelve los textos seedeados como mapa clave→valor', function () {
    $this->seed(ContenidoSeeder::class);

    $this->getJson('/api/contenido')
        ->assertOk()
        ->assertJsonFragment(['hero.eslogan' => 'REVISAMOS. DETECTAMOS. SOLUCIONAMOS.'])
        ->assertJsonFragment(['footer.dominio' => 'auditatucomunidad.com']);
});

it('refleja al instante un texto editado (invalida la caché)', function () {
    $this->seed(ContenidoSeeder::class);

    // Primera petición: deja el mapa cacheado.
    $this->getJson('/api/contenido')->assertJsonFragment(['precio.importe' => '100€']);

    Contenido::where('clave', 'precio.importe')->first()->update(['valor' => '120€']);

    $this->getJson('/api/contenido')->assertJsonFragment(['precio.importe' => '120€']);
});

it('no permite la edición en vivo sin sesión de admin', function () {
    $this->seed(ContenidoSeeder::class);

    $this->putJson('/api/contenido/hero.eslogan', ['valor' => 'Hackeado'])
        ->assertUnauthorized();

    $this->getJson('/api/contenido/estado-edicion')->assertOk()->assertJson(['admin' => false]);
});

it('permite a un admin editar en vivo y el cambio se publica al instante', function () {
    $this->seed(ContenidoSeeder::class);
    $admin = \App\Models\User::factory()->create();

    $this->actingAs($admin)->getJson('/api/contenido/estado-edicion')->assertJson(['admin' => true]);

    $this->actingAs($admin)
        ->putJson('/api/contenido/hero.eslogan', ['valor' => 'ESLOGAN NUEVO'])
        ->assertOk()
        ->assertJson(['clave' => 'hero.eslogan', 'valor' => 'ESLOGAN NUEVO']);

    $this->getJson('/api/contenido')->assertJsonFragment(['hero.eslogan' => 'ESLOGAN NUEVO']);
});

it('rechaza la edición en vivo de una clave inexistente o un valor vacío', function () {
    $this->seed(ContenidoSeeder::class);
    $admin = \App\Models\User::factory()->create();

    $this->actingAs($admin)->putJson('/api/contenido/clave.inventada', ['valor' => 'X'])
        ->assertNotFound();

    $this->actingAs($admin)->putJson('/api/contenido/hero.eslogan', ['valor' => ''])
        ->assertUnprocessable();
});
