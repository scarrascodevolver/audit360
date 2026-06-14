<?php

namespace App\Http\Requests;

use App\Rules\ArchivoPermitido;
use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreEnvioRequest extends FormRequest
{
    public const SLOTS = ['actas', 'presupuesto', 'contratos', 'incidencias'];

    public const MAX_ARCHIVOS = 15;

    // Cloudflare (plan gratis) corta las subidas en 100 MB; dejamos margen.
    public const MAX_BYTES_TOTAL = 95 * 1024 * 1024;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $archivo = ['file', 'max:20480', new ArchivoPermitido];

        $reglas = [
            'comunidad' => ['nullable', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'min:9', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
            'consentimiento' => ['accepted'],
            // Sin clave configurada (dev local) no se exige el token.
            'turnstile_token' => [
                Rule::requiredIf(filled(config('services.turnstile.secret'))),
                'string',
                new Turnstile,
            ],
            'documentos' => ['required', 'array'],
            'documentos.otros' => ['sometimes', 'array'],
            'documentos.otros.*' => $archivo,
        ];

        foreach (self::SLOTS as $slot) {
            $reglas["documentos.{$slot}"] = ['sometimes', ...$archivo];
        }

        return $reglas;
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $total = count($this->archivos());

                if ($total === 0) {
                    $validator->errors()->add('documentos', 'Adjunte al menos un documento.');
                }

                if ($total > self::MAX_ARCHIVOS) {
                    $validator->errors()->add('documentos', 'No se pueden enviar más de '.self::MAX_ARCHIVOS.' archivos.');
                }

                $bytes = array_sum(array_map(fn (array $par): int => $par[1]->getSize(), $this->archivos()));

                if ($bytes > self::MAX_BYTES_TOTAL) {
                    $validator->errors()->add('documentos', 'El total de los archivos no puede superar los 95 MB por envío.');
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
            'documentos' => 'documentos',
            'documentos.actas' => 'archivo de actas',
            'documentos.presupuesto' => 'archivo de presupuesto',
            'documentos.contratos' => 'archivo de contratos',
            'documentos.incidencias' => 'archivo de incidencias',
            'documentos.otros' => 'otros documentos',
            'documentos.otros.*' => 'archivo adjunto',
        ];
    }

    /**
     * Archivos subidos como pares [slot, archivo]. Los del dropzone
     * comparten el slot "otros".
     *
     * @return array<int, array{0: string, 1: UploadedFile}>
     */
    public function archivos(): array
    {
        $pares = [];

        foreach (self::SLOTS as $slot) {
            $archivo = $this->file("documentos.{$slot}");

            if ($archivo instanceof UploadedFile) {
                $pares[] = [$slot, $archivo];
            }
        }

        foreach ($this->file('documentos.otros', []) as $archivo) {
            if ($archivo instanceof UploadedFile) {
                $pares[] = ['otros', $archivo];
            }
        }

        return $pares;
    }
}
