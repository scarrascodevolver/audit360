<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'envio_id',
        'slot',
        'nombre_original',
        'ruta',
        'tamano_bytes',
        'mime',
    ];

    public function envio(): BelongsTo
    {
        return $this->belongsTo(Envio::class);
    }
}
