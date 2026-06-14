<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ajuste extends Model
{
    public const CACHE_KEY = 'ajustes';

    // Claves conocidas.
    public const EMAIL_NOTIFICACIONES = 'email_notificaciones';

    public const ADJUNTAR_ARCHIVOS = 'adjuntar_archivos';

    protected $table = 'ajustes';

    protected $fillable = [
        'clave',
        'valor',
    ];

    protected static function booted(): void
    {
        $invalidar = fn () => Cache::forget(self::CACHE_KEY);

        static::saved($invalidar);
        static::deleted($invalidar);
    }

    /** Mapa clave → valor, cacheado. NO se expone públicamente. */
    public static function mapa(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return self::query()->pluck('valor', 'clave')->all();
        });
    }

    public static function get(string $clave, mixed $default = null): mixed
    {
        return self::mapa()[$clave] ?? $default;
    }

    public static function set(string $clave, ?string $valor): void
    {
        self::updateOrCreate(['clave' => $clave], ['valor' => $valor]);
    }

    /** Interpreta un ajuste guardado como '1'/'0' como booleano. */
    public static function bool(string $clave, bool $default = false): bool
    {
        $valor = self::get($clave);

        return $valor === null ? $default : (bool) (int) $valor;
    }

    /**
     * Lista de correos que reciben el aviso de cada envío. Sale del panel
     * (varios separados por comas); si no hay, cae al .env.
     *
     * @return array<int, string>
     */
    public static function emailsNotificaciones(): array
    {
        $valor = self::get(self::EMAIL_NOTIFICACIONES) ?: config('audit360.especialista_email');

        return collect(explode(',', (string) $valor))
            ->map(fn (string $email): string => trim($email))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
