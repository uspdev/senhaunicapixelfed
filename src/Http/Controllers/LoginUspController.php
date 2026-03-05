<?php

namespace Uspdev\SenhaUnicaPixelfed\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\User;


class LoginUspController extends Controller
{
    public function index()
    {
        return view('senhaunicapixelfed::loginusp');
    }

    public function store(Request $request) {
        $user = User::firstOrcreate(
            ['email' => $request->email],
            ['password' => Hash::make(Str::random(40))]
        );
        
        Auth::login($user);
        $request->session()->regenerate();
        
        return redirect('/@');
    }
}