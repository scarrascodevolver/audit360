<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basta con uno de los dos; la regla de "al menos uno" va en after().
            'telefono' => ['nullable', 'string', 'min:9', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'consentimiento' => ['accepted'],
            // Sin clave configurada (dev local) no se exige el token.
            'turnstile_token' => [
                Rule::requiredIf(filled(config('services.turnstile.secret'))),
                'string',
                new Turnstile,
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (blank($this->input('telefono')) && blank($this->input('email'))) {
                    $validator->errors()->add('telefono', 'Indique un teléfono o un email para que podamos contactarle.');
                }
            },
        ];
    }

    public function attributes(): array
    {
        return [
            'telefono' => 'teléfono de contacto',
            'email' => 'email de contacto',
            'consentimiento' => 'consentimiento de datos',
            'turnstile_token' => 'verificación anti-spam',
        ];
    }
}
