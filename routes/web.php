<?php

use Illuminate\Support\Facades\Route;

// Mockup estático: todas las rutas sirven la SPA de Vue.
// El enrutado real ( / y /recopilacion ) lo gestiona Vue Router.
Route::view('/{any?}', 'app')->where('any', '.*');
