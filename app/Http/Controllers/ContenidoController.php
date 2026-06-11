<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Contenido::mapa());
    }

    /** La SPA pregunta si hay sesión de admin para activar el modo edición. */
    public function estadoEdicion(): JsonResponse
    {
        return response()->json(['admin' => auth()->check()]);
    }

    /** Edición en vivo desde la web (solo admins, ruta con middleware auth). */
    public function update(Request $request, string $clave): JsonResponse
    {
        $datos = $request->validate([
            'valor' => ['required', 'string', 'max:5000'],
        ]);

        $contenido = Contenido::where('clave', $clave)->firstOrFail();
        $contenido->update(['valor' => $datos['valor']]);

        return response()->json(['clave' => $clave, 'valor' => $contenido->valor]);
    }
}
