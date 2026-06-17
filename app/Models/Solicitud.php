<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public const ESTADO_NUEVA = 'nueva';
    public const ESTADO_CONTACTADA = 'contactada';

    protected $table = 'solicitudes';

    protected $attributes = [
        'estado' => self::ESTADO_NUEVA,
    ];

    protected $fillable = [
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
}
