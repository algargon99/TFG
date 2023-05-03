<?php

use Illuminate\Support\Facades\Route;

Route::get('/mostrarCoros', [CoroController::class, 'mostrarCoros'])->name('mostrarCoros');

