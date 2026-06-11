<?php

use App\Http\Controllers\EnvioController;
use Illuminate\Support\Facades\Route;

Route::post('/envios', [EnvioController::class, 'store'])->middleware('throttle:envios');
