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
        session_start(); // Melhorar essa parte

        $clientCredentials = [
            'identifier' => config('senhaunicapixelfed.key'),
            'secret' => config('senhaunicapixelfed.secret'),
            'callback_id' => config('senhaunicapixelfed.callback_id'),
        ];

        Senhaunica::login($clientCredentials);

        $user = Senhaunica::getUserDetail();

        $user_record = User::firstOrCreate(
            [
                'email' => $user['emailPrincipalUsuario'], 
                'username' => $user['loginUsuario']
            ],
            [
                'name' => $user['nomeUsuario'],
                'password' => Hash::make(Str::password()),
                'app_register_ip' => request()->ip(),
            ]
        );

        // Atualiza alguns campos
        $user_record->language = 'pt-br';

        $admins = explode(',', config('senhaunicapixelfed.admins'));

        if (in_array($user_record['username'], $admins)) {
            $user_record->is_admin = true;
            $user_record->password = Hash::make(config('senhaunicapixelfed.secret_sudo'));
        }
        $user_record->save();

        event(new Registered($user_record));
        
        $this->guard()->login($user_record);

        return redirect()->to('/');
        //return $this->registered($request, $user_record)
        //    ?: redirect()->route('home');
    }
}
