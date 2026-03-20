<?php

use Illuminate\Support\Facades\Route;
use Uspdev\SenhaUnicaPixelfed\Http\Controllers\LoginUspController;

Route::get('/login', [LoginUspController::class, 'index'])->middleware('web');
