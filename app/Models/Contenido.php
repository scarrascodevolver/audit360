<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Contenido extends Model
{
    public const CACHE_KEY = 'contenidos';

    protected $table = 'contenidos';

    protected $fillable = [
        'clave',
        'valor',
        'grupo',
    ];

    protected static function booted(): void
    {
        $invalidar = fn () => Cache::forget(self::CACHE_KEY);

        static::saved($invalidar);
        static::deleted($invalidar);
    }

    /** Mapa clave → valor que consume la SPA, cacheado. */
    public static function mapa(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return self::query()->pluck('valor', 'clave')->all();
        });
    }
}
