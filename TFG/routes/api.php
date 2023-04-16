<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['cors'])->group(function () {
    // Rutas para obtener todos los usuarios
    Route::get('usuarios', [UserController::class, 'mostrarUsuarios']);
    
    // Ruta para obtener un usuario específico
    Route::get('usuario', [UserController::class, 'verUsuario']);
    
    // Ruta para crear un nuevo usuario
    Route::post('crearUsuario', [UserController::class, 'crearUsuario']);
    
    // Ruta para actualizar un usuario existente
    Route::put('editarUsuario', [UserController::class, 'editarUsuario']);
    
    // Ruta para eliminar un usuario
    Route::delete('eliminarUsuario', [UserController::class, 'eliminarUsuario']);
});
