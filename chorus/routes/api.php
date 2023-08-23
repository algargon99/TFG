<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\CantorController;
use App\Http\Controllers\CoroController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\PartituraController;
use App\Http\Controllers\RelUsuarioCoroController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UsuarioController;
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


Route::post('login', [UsuarioController::class, 'login']);
Route::get('usuario/{id}', [UsuarioController::class, 'datosUsuario']);
Route::get('usuarios', [UsuarioController::class, 'usuarios']);
Route::put('usuario/{id}', [UsuarioController::class, 'editarPerfil']);
Route::post('usuario', [UsuarioController::class, 'contacto']);
Route::post('cuenta', [UsuarioController::class, 'cuenta']);
Route::put('cambiarPass/{id}', [UsuarioController::class, 'cambiarPass']);
Route::put('cambiarImagen/{id}', [UsuarioController::class, 'cambiarImagen']);


//CORO-USUARIO
Route::post('asignarCoro', [RelUsuarioCoroController::class, 'asignarCoro']);
Route::delete('relsdesasignar', [RelUsuarioCoroController::class, 'desasignarCoro']);

//COROS
Route::apiResource('coros', CoroController::class);
Route::get('corosUsuario/{id}', [CoroController::class, 'corosUsuario']);
Route::get('cantoresCoro/{id}', [CoroController::class, 'cantoresCoro']);
Route::get('directoresCoro/{id}', [CoroController::class, 'directoresCoro']);

//CANTORES
Route::apiResource('cantores', CantorController::class);


//DIRECTORES
Route::apiResource('directores', DirectorController::class);

//PARTITURAS
Route::get('coros/{id}/partituras', [PartituraController::class, 'index']);
Route::get('partituras/{id}', [PartituraController::class, 'show']);
Route::post('partituras/{id}', [PartituraController::class, 'store']);
Route::put('partituras/{id}', [PartituraController::class, 'update']);
Route::delete('partituras/{id}', [PartituraController::class, 'destroy']);


//AUDIOS
Route::get('partitura/{id}/audios/', [AudioController::class, 'index']);
Route::get('audios/{id}', [AudioController::class, 'show']);
Route::post('audios/{id}', [AudioController::class, 'store']);
Route::put('audios/{id}', [AudioController::class, 'update']);
Route::delete('audios/{id}', [AudioController::class, 'destroy']);

//VIDEOS
Route::get('partitura/{id}/videos/', [VideoController::class, 'index']);
Route::get('videos/{id}', [VideoController::class, 'show']);
Route::post('videos/{id}', [VideoController::class, 'store']);
Route::put('videos/{id}', [VideoController::class, 'update']);
Route::delete('videos/{id}', [VideoController::class, 'destroy']);
