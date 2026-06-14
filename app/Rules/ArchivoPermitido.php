<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ArchivoPermitido implements ValidationRule
{
    // Extensión → tipos MIME (finfo) aceptables para ella. Office moderno
    // (xlsx/docx/ods/odt) es un ZIP por dentro, por eso se admite
    // application/zip además del tipo "oficial" (según la versión de
    // libmagic finfo devuelve uno u otro). Se valida extensión Y contenido:
    // así un ejecutable renombrado a .pdf no cuela.
    private const PERMITIDOS = [
        'pdf' => ['application/pdf'],
        'jpg' => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png' => ['image/png'],
        'xlsx' => ['application/zip', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'docx' => ['application/zip', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'ods' => ['application/zip', 'application/vnd.oasis.opendocument.spreadsheet'],
        'odt' => ['application/zip', 'application/vnd.oasis.opendocument.text'],
        'xls' => ['application/vnd.ms-excel', 'application/x-ole-storage', 'application/vnd.ms-office', 'application/CDFV2'],
        'doc' => ['application/msword', 'application/x-ole-storage', 'application/vnd.ms-office', 'application/CDFV2'],
        'csv' => ['text/plain', 'text/csv', 'application/csv'],
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            $fail('El archivo no se ha subido correctamente.');

            return;
        }

        $ext = strtolower($value->getClientOriginalExtension());
        $aceptables = self::PERMITIDOS[$ext] ?? null;
        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $value->getRealPath());

        if ($aceptables === null || ! in_array($mime, $aceptables, true)) {
            $fail('Solo se admiten PDF, imágenes (JPG/PNG), Excel, Word, LibreOffice o CSV.');
        }
    }
}
