<?php

use App\Http\Controllers\CoroController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CoroController::class, 'mostrarCoros'])->name('mostrarCoros');

