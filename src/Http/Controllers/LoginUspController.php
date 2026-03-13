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

    public function index()
    {   
        /*$clientCredentials = [
            'identifier' => 'identificacao',
            'secret' => 'chave-secreta',
            'callback_id' => 0,
        ];

        Senhaunica::login($clientCredentials);
        */

        return view('senhaunicapixelfed::loginusp');
    }

    public function create(array $data)
    {
        return User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => Purify::clean($data['name']),
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'app_register_ip' => request()->ip(),
            ]
        );
    }


    public function store(Request $request) {
        event(new Registered($user = $this->create($request->all()
            + [
                'password' => Str::random(40),
                'name' => Str::random(10),
                'username' => Str::random(5)
            ]
        )));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}