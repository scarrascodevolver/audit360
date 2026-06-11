<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use Illuminate\Http\JsonResponse;

class ContenidoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Contenido::mapa());
    }
}
