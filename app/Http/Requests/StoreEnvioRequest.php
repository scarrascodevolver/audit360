<?php

namespace App\Http\Requests;

use App\Rules\ArchivoPermitido;
use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;

class StoreEnvioRequest extends FormRequest
{
    public const SLOTS = ['actas', 'presupuesto', 'contratos', 'incidencias'];

    public const MAX_ARCHIVOS = 15;

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
            'turnstile_token' => ['required', 'string', new Turnstile],
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
            },
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
