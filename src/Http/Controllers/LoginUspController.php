<?php

namespace Uspdev\SenhaUnicaPixelfed\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use Purify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Uspdev\Senhaunica\Senhaunica;

class LoginUspController extends Controller
{   
    use RegistersUsers;
    
    protected $redirectTo = '/i/web';

    public function index(Request $request)
    {   
        session_start(); // Mlehorar essa parte

        $clientCredentials = [
            'identifier' => env('SENHAUNICAPIXELFED_KEY'),
            'secret' => env('SENHAUNICAPIXELFED_SECRET'),
            'callback_id' => env('SENHAUNICAPIXELFED_CALLBACK_ID'),
        ];

        Senhaunica::login($clientCredentials);

        $user = Senhaunica::getUserDetail();

        event(new Registered($user_record = User::firstOrCreate(
            [
                'email' => $user['emailPrincipalUsuario'], 
                'username' => $user['loginUsuario']
            ],
            [
                'name' => $user['nomeUsuario'],
                'password' => Hash::make(Str::password()),
                'app_register_ip' => request()->ip(),
            ]
            
        )));
        
        $this->guard()->login($user_record);
        
        return $this->registered($request, $user_record)
            ?: redirect()->route('home');
    }
}