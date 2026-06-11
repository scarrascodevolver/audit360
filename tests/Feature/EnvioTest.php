<?php

use App\Models\Documento;
use App\Models\Envio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('envios');
    Mail::fake();
    RateLimiter::clear('envios|127.0.0.1');

    config()->set('services.turnstile.secret', 'test-secret');
    config()->set('audit360.especialista_email', 'especialista@example.com');

    // Cloudflare valida el token server-side; por defecto responde OK.
    Http::fake([
        'challenges.cloudflare.com/*' => Http::response(['success' => true]),
    ]);
});

function datosValidos(array $overrides = []): array
{
    return array_merge([
        'comunidad' => 'Comunidad C/ Mayor 12',
        'telefono' => '600123456',
        'email' => 'vecino@example.com',
        'consentimiento' => '1',
        'turnstile_token' => 'token-valido',
        'documentos' => [
            'actas' => UploadedFile::fake()->create('acta.pdf', 100, 'application/pdf'),
        ],
    ], $overrides);
}

it('acepta un envío válido y persiste envío y documentos', function () {
    $respuesta = $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => UploadedFile::fake()->create('acta.pdf', 100, 'application/pdf'),
            'otros' => [
                UploadedFile::fake()->image('foto.jpg'),
            ],
        ],
    ]));

    $respuesta->assertCreated()->assertJsonStructure(['id']);

    $envio = Envio::findOrFail($respuesta->json('id'));
    expect($envio->telefono)->toBe('600123456')
        ->and($envio->email)->toBe('vecino@example.com')
        ->and($envio->estado)->toBe(Envio::ESTADO_NUEVO)
        ->and($envio->consentimiento_at)->not->toBeNull()
        ->and($envio->documentos)->toHaveCount(2);

    foreach ($envio->documentos as $documento) {
        Storage::disk('envios')->assertExists($documento->ruta);
    }
});

it('guarda los archivos cifrados en reposo y recuperables con decrypt', function () {
    $contenido = '%PDF-1.4 contenido-secreto';
    $archivo = UploadedFile::fake()->createWithContent('acta.pdf', $contenido);

    $this->postJson('/api/envios', datosValidos([
        'documentos' => ['actas' => $archivo],
    ]))->assertCreated();

    $documento = Documento::firstOrFail();
    $enDisco = Storage::disk('envios')->get($documento->ruta);

    expect($enDisco)->not->toContain('contenido-secreto')
        ->and(decrypt($enDisco))->toBe($contenido);
});

it('rechaza el envío sin teléfono', function () {
    $this->postJson('/api/envios', datosValidos(['telefono' => '']))
        ->assertUnprocessable()->assertJsonValidationErrors('telefono');
});

it('rechaza el envío sin email o con email inválido', function () {
    $this->postJson('/api/envios', datosValidos(['email' => '']))
        ->assertUnprocessable()->assertJsonValidationErrors('email');

    $this->postJson('/api/envios', datosValidos(['email' => 'no-es-un-email']))
        ->assertUnprocessable()->assertJsonValidationErrors('email');
});

it('rechaza el envío sin consentimiento RGPD', function () {
    $this->postJson('/api/envios', datosValidos(['consentimiento' => '']))
        ->assertUnprocessable()->assertJsonValidationErrors('consentimiento');
});

it('rechaza el envío cuando Turnstile no valida el token', function () {
    Http::fake([
        'challenges.cloudflare.com/*' => Http::response(['success' => false]),
    ]);

    $this->postJson('/api/envios', datosValidos())
        ->assertUnprocessable()->assertJsonValidationErrors('turnstile_token');
});

it('rechaza el envío sin ningún archivo', function () {
    $this->postJson('/api/envios', datosValidos(['documentos' => []]))
        ->assertUnprocessable()->assertJsonValidationErrors('documentos');
});

it('rechaza más de 15 archivos en total', function () {
    $otros = collect(range(1, 15))
        ->map(fn ($i) => UploadedFile::fake()->create("extra-{$i}.pdf", 10, 'application/pdf'))
        ->all();

    $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => UploadedFile::fake()->create('acta.pdf', 10, 'application/pdf'),
            'otros' => $otros,
        ],
    ]))->assertUnprocessable()->assertJsonValidationErrors('documentos');
});

it('rechaza archivos de más de 20 MB', function () {
    $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => UploadedFile::fake()->create('acta.pdf', 21 * 1024, 'application/pdf'),
        ],
    ]))->assertUnprocessable();
});

it('rechaza archivos que no son PDF/JPG/PNG aunque lleven otra extensión', function () {
    $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => UploadedFile::fake()->createWithContent('acta.pdf', 'MZ ejecutable'),
        ],
    ]))->assertUnprocessable();
});

it('encola el email de aviso al especialista', function () {
    $this->postJson('/api/envios', datosValidos())->assertCreated();

    Mail::assertQueued(\App\Mail\EnvioRecibidoMail::class, function ($mail) {
        return $mail->hasTo('especialista@example.com');
    });
});

it('limita a 5 envíos por hora por IP', function () {
    foreach (range(1, 5) as $i) {
        $this->postJson('/api/envios', datosValidos())->assertCreated();
    }

    $this->postJson('/api/envios', datosValidos())->assertTooManyRequests();
});
