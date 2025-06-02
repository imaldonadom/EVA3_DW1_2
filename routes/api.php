<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta de login
Route::post('/login', [AuthController::class, 'login']);

// Grupo protegido por JWT
Route::middleware('auth:api')->group(function () {
    Route::get('/usuario', function () {
        return auth()->user();
    });

    // Aquí puedes agregar más rutas protegidas
});
