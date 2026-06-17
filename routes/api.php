<?php

use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::post('/solicitudes', [SolicitudController::class, 'store'])->middleware('throttle:envios');
Route::post('/envios', [EnvioController::class, 'store'])->middleware('throttle:envios');
Route::get('/contenido', [ContenidoController::class, 'index']);
