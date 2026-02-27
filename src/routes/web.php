<?php

use Illuminate\Support\Facades\Route;
use Uspdev\SenhaUnicaPixelfed\Http\Controllers\LoginUspController;

Route::get('/loginusp', [LoginUspController::class, 'index']);
Route::get('/loginusp2', [LoginUspController::class, 'index']);
