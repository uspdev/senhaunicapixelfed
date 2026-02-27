<?php

namespace Uspdev\SenhaUnicaPixelfed\Http\Controllers;

use Illuminate\Routing\Controller;

class LoginUspController extends Controller
{
    public function index()
    {
        return view('senhaunicapixelfed::loginusp');
    }
}
