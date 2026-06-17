<?php

use App\Mail\SolicitudRecibidaMail;
use App\Models\Ajuste;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    Mail::fake();
    Cache::flush();
    RateLimiter::clear('envios|127.0.0.1');

    config()->set('services.turnstile.secret', 'test-secret');
    config()->set('audit360.especialista_email', 'especialista@example.com');

    Http::fake(function ($request) {
        return Http::response(['success' => $request['response'] !== 'token-invalido']);
    });
});

function datosSolicitud(array $overrides = []): array
{
    return array_merge([
        'telefono' => '600123456',
        'email' => 'vecino@example.com',
        'consentimiento' => '1',
        'turnstile_token' => 'token-valido',
    ], $overrides);
}

it('acepta una solicitud solo con teléfono', function () {
    $this->postJson('/api/solicitudes', datosSolicitud(['email' => '']))
        ->assertCreated()->assertJsonStructure(['id']);

    $solicitud = Solicitud::firstOrFail();
    expect($solicitud->telefono)->toBe('600123456')
        ->and($solicitud->estado)->toBe(Solicitud::ESTADO_NUEVA)
        ->and($solicitud->consentimiento_at)->not->toBeNull();
});

it('acepta una solicitud solo con email', function () {
    $this->postJson('/api/solicitudes', datosSolicitud(['telefono' => '']))
        ->assertCreated();
});

it('rechaza la solicitud sin teléfono ni email', function () {
    $this->postJson('/api/solicitudes', datosSolicitud(['telefono' => '', 'email' => '']))
        ->assertUnprocessable()->assertJsonValidationErrors('telefono');
});

it('rechaza la solicitud sin consentimiento RGPD', function () {
    $this->postJson('/api/solicitudes', datosSolicitud(['consentimiento' => '']))
        ->assertUnprocessable()->assertJsonValidationErrors('consentimiento');
});

it('rechaza la solicitud cuando Turnstile no valida el token', function () {
    $this->postJson('/api/solicitudes', datosSolicitud(['turnstile_token' => 'token-invalido']))
        ->assertUnprocessable()->assertJsonValidationErrors('turnstile_token');
});

it('encola el aviso de solicitud y, sin lista propia, cae en los avisos generales', function () {
    $this->postJson('/api/solicitudes', datosSolicitud())->assertCreated();

    Mail::assertQueued(SolicitudRecibidaMail::class, function ($mail) {
        return $mail->hasTo('especialista@example.com');
    });
});

it('manda el aviso de solicitud a la lista de solicitudes cuando se configura', function () {
    Ajuste::set(Ajuste::EMAIL_SOLICITUDES, 'llamadas@nexofincas.es');
    Ajuste::set(Ajuste::EMAIL_NOTIFICACIONES, 'documentos@nexofincas.es');

    $this->postJson('/api/solicitudes', datosSolicitud())->assertCreated();

    Mail::assertQueued(SolicitudRecibidaMail::class, function ($mail) {
        return $mail->hasTo('llamadas@nexofincas.es') && ! $mail->hasTo('documentos@nexofincas.es');
    });
});

it('limita las solicitudes por hora por IP', function () {
    config()->set('audit360.envios_por_hora', 3);

    foreach (range(1, 3) as $i) {
        $this->postJson('/api/solicitudes', datosSolicitud())->assertCreated();
    }

    $this->postJson('/api/solicitudes', datosSolicitud())->assertTooManyRequests();
});
