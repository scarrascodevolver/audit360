<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.turnstile.secret');

        // Sin clave configurada (dev local) no se exige verificación.
        if (blank($secret)) {
            return;
        }

        $respuesta = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $respuesta->json('success')) {
            $fail('La verificación anti-spam ha fallado. Recargue la página e inténtelo de nuevo.');
        }
    }
}
