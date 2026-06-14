<?php

use App\Mail\EnvioRecibidoMail;
use App\Models\Ajuste;
use App\Models\Documento;
use App\Models\Envio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('envios');
    Mail::fake();
    Cache::flush();
    RateLimiter::clear('envios|127.0.0.1');

    config()->set('services.turnstile.secret', 'test-secret');
    config()->set('audit360.especialista_email', 'especialista@example.com');

    // Cloudflare valida el token server-side: el fake da OK a cualquier
    // token salvo a "token-invalido".
    Http::fake(function ($request) {
        return Http::response(['success' => $request['response'] !== 'token-invalido']);
    });
});

// La validación de tipo es por contenido real (finfo), así que los
// archivos de prueba llevan los bytes mágicos de un PDF de verdad.
function pdfFalso(string $nombre = 'acta.pdf'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($nombre, '%PDF-1.4 contenido de prueba');
}

function datosValidos(array $overrides = []): array
{
    return array_merge([
        'comunidad' => 'Comunidad C/ Mayor 12',
        'telefono' => '600123456',
        'email' => 'vecino@example.com',
        'consentimiento' => '1',
        'turnstile_token' => 'token-valido',
        'documentos' => [
            'actas' => pdfFalso(),
        ],
    ], $overrides);
}

it('acepta un envío válido y persiste envío y documentos', function () {
    $respuesta = $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => pdfFalso(),
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
    $this->postJson('/api/envios', datosValidos(['turnstile_token' => 'token-invalido']))
        ->assertUnprocessable()->assertJsonValidationErrors('turnstile_token');
});

it('rechaza el envío sin ningún archivo', function () {
    $this->postJson('/api/envios', datosValidos(['documentos' => []]))
        ->assertUnprocessable()->assertJsonValidationErrors('documentos');
});

it('rechaza más de 15 archivos en total', function () {
    $otros = collect(range(1, 15))
        ->map(fn ($i) => pdfFalso("extra-{$i}.pdf"))
        ->all();

    $this->postJson('/api/envios', datosValidos([
        'documentos' => [
            'actas' => pdfFalso(),
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

    Mail::assertQueued(EnvioRecibidoMail::class, function ($mail) {
        return $mail->hasTo('especialista@example.com');
    });
});

it('el correo de aviso configurado en el panel manda sobre el del .env', function () {
    Ajuste::set(Ajuste::EMAIL_NOTIFICACIONES, 'administracion@nexofincas.es');

    $this->postJson('/api/envios', datosValidos())->assertCreated();

    Mail::assertQueued(EnvioRecibidoMail::class, function ($mail) {
        return $mail->hasTo('administracion@nexofincas.es');
    });
});

it('envía el aviso a varios destinatarios si se configuran', function () {
    Ajuste::set(Ajuste::EMAIL_NOTIFICACIONES, 'administracion@nexofincas.es, gestor@nexofincas.es');

    $this->postJson('/api/envios', datosValidos())->assertCreated();

    Mail::assertQueued(EnvioRecibidoMail::class, function ($mail) {
        return $mail->hasTo('administracion@nexofincas.es')
            && $mail->hasTo('gestor@nexofincas.es');
    });
});

it('adjunta los archivos cuando caben y el ajuste lo permite', function () {
    $this->postJson('/api/envios', datosValidos())->assertCreated();

    $envio = Envio::firstOrFail();
    $mail = new EnvioRecibidoMail($envio);

    expect($mail->debeAdjuntar())->toBeTrue()
        ->and($mail->attachments())->toHaveCount(1);
});

it('no adjunta si el ajuste de adjuntar está desactivado', function () {
    Ajuste::set(Ajuste::ADJUNTAR_ARCHIVOS, '0');

    $this->postJson('/api/envios', datosValidos())->assertCreated();

    $envio = Envio::firstOrFail();
    $mail = new EnvioRecibidoMail($envio);

    expect($mail->debeAdjuntar())->toBeFalse()
        ->and($mail->attachments())->toBeEmpty();
});

it('no adjunta si el envío supera el límite de tamaño del correo', function () {
    $this->postJson('/api/envios', datosValidos())->assertCreated();

    $envio = Envio::firstOrFail();
    // Simula un documento gigante: el peso total supera el tope.
    $envio->documentos()->update([
        'tamano_bytes' => EnvioRecibidoMail::LIMITE_ADJUNTOS_BYTES + 1,
    ]);

    $mail = new EnvioRecibidoMail($envio->fresh());

    expect($mail->debeAdjuntar())->toBeFalse();
});

it('limita a 5 envíos por hora por IP', function () {
    config()->set('audit360.envios_por_hora', 5);

    foreach (range(1, 5) as $i) {
        $this->postJson('/api/envios', datosValidos())->assertCreated();
    }

    $this->postJson('/api/envios', datosValidos())->assertTooManyRequests();
});
