<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ArchivoPermitido implements ValidationRule
{
    // Se valida por contenido real (finfo), no por extensión.
    private const MIMES_PERMITIDOS = [
        'application/pdf',
        'image/jpeg',
        'image/png',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            $fail('El archivo no se ha subido correctamente.');

            return;
        }

        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $value->getRealPath());

        if (! in_array($mime, self::MIMES_PERMITIDOS, true)) {
            $fail('Solo se admiten archivos PDF, JPG o PNG.');
        }
    }
}
