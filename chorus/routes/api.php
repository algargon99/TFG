<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\CantorController;
use App\Http\Controllers\CoroController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\PartituraController;
use App\Http\Controllers\VideoController;
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
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');

//COROS
Route::apiResource('coros', CoroController::class);

//CANTORES
Route::apiResource('cantores', CantorController::class);

//DIRECTORES
Route::apiResource('directores', DirectorController::class);

//PARTITURAS
Route::get('coros/{id}/partituras', [PartituraController::class,'index']);
Route::get('partituras/{id}', [PartituraController::class,'show']);
Route::post('partituras/{id}', [PartituraController::class,'store']);

//AUDIOS
Route::apiResource('audios', AudioController::class);

//VIDEOS
Route::apiResource('videos', VideoController::class);