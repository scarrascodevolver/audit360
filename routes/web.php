<?php

use App\Http\Controllers\ContenidoController;
use Illuminate\Support\Facades\Route;

// Edición en vivo de textos: van por web.php porque necesitan la sesión
// (cookie del admin de Filament) y CSRF, que el grupo api no tiene.
Route::get('/api/contenido/estado-edicion', [ContenidoController::class, 'estadoEdicion']);
Route::put('/api/contenido/{clave}', [ContenidoController::class, 'update'])->middleware('auth');

// Todas las demás rutas sirven la SPA de Vue (el enrutado lo hace Vue Router).
Route::view('/{any?}', 'app')->where('any', '.*');
