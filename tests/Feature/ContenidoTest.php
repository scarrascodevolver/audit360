<?php

use App\Models\Contenido;
use Database\Seeders\ContenidoSeeder;

it('devuelve los textos seedeados como mapa clave→valor', function () {
    $this->seed(ContenidoSeeder::class);

    $this->getJson('/api/contenido')
        ->assertOk()
        ->assertJsonFragment(['hero.eslogan' => 'ANALIZAMOS. DETECTAMOS. MEJORAMOS.'])
        ->assertJsonFragment(['footer.dominio' => 'auditatucomunidad.com']);
});

it('refleja al instante un texto editado (invalida la caché)', function () {
    $this->seed(ContenidoSeeder::class);

    // Primera petición: deja el mapa cacheado.
    $this->getJson('/api/contenido')->assertJsonFragment(['precio.importe' => '100€']);

    Contenido::where('clave', 'precio.importe')->first()->update(['valor' => '120€']);

    $this->getJson('/api/contenido')->assertJsonFragment(['precio.importe' => '120€']);
});
