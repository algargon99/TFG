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

//COROS
Route::apiResource('coros', CoroController::class);

//CANTORES
Route::apiResource('cantores', CantorController::class);

//DIRECTORES
Route::apiResource('directores', DirectorController::class);

//PARTITURAS
Route::apiResource('partituras', PartituraController::class);

//AUDIOS
Route::apiResource('audios', AudioController::class);

//VIDEOS
Route::apiResource('videos', VideoController::class);