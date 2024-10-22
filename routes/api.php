<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("usuario")->group(function() {
    Route::post("cadastrar", [\App\Http\Controllers\Usuario\UsuarioController::class, 'cadastrarUsuario']);
    Route::post("auth", [\App\Http\Controllers\Usuario\UsuarioController::class, 'authAPI']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
