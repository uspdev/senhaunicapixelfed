<?php

use Illuminate\Support\Facades\Route;
use Uspdev\SenhaUnicaPixelfed\Http\Controllers\LoginUspController;

Route::get('/loginusp', [LoginUspController::class, 'index']);
