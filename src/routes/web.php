<?php

use Illuminate\Support\Facades\Route;
use Uspdev\SenhaUnicaPixelfed\Http\Controllers\LoginUspController;

Route::get('/loginusp', [LoginUspController::class, 'index'])->middleware('web');
Route::post('/store', [LoginUspController::class, 'store'])->middleware('web');