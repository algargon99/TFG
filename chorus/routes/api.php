<?php

use App\Http\Controllers\CantorController;
use App\Http\Controllers\CoroController;
use Illuminate\Http\Request;
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

//COROS
Route::get('/', [CoroController::class, 'mostrarCoros'])->name('mostrarCoros');
Route::post('/crearCoro', [CoroController::class, 'crearCoro'])->name('crearCoro');
Route::delete('/{id}', [CoroController::class, 'eliminarCoro'])->name('eliminarCoro');

//CANTORES
Route::get('/cantores', [CantorController::class, 'mostrarCantores'])->name('mostrarCantores');
Route::delete('/cantores/{id}', [CantorController::class, 'eliminarCantor'])->name('eliminarCantor');