<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Envio extends Model
{
    public const ESTADO_NUEVO = 'nuevo';
    public const ESTADO_REVISADO = 'revisado';

    protected $table = 'envios';

    protected $attributes = [
        'estado' => self::ESTADO_NUEVO,
    ];

    protected $fillable = [
        'comunidad',
        'telefono',
        'email',
        'estado',
        'consentimiento_at',
    ];

    protected function casts(): array
    {
        return [
            'consentimiento_at' => 'datetime',
        ];
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }
}
