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



class LoginUspController extends Controller
{   
    use RegistersUsers;
    
    protected $redirectTo = '/i/web';

    public function index()
    {
        return view('senhaunicapixelfed::loginusp');
    }

    public function create(array $data)
    {
        // if (config('database.default') == 'pgsql') {
        //     $data['username'] = strtolower($data['username']);
        //     $data['email'] = strtolower($data['email']);
        // }

        return User::create([
            'name' => Purify::clean($data['name']),
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'app_register_ip' => request()->ip(),
        ]);
    }


    public function store(Request $request) {
        // dd($request->all() + ['password' => Hash::make(Str::random(40))]);
        // $user = User::firstOrCreate(
        //     ['email' => $request->email],
        //     ['password' => Hash::make(Str::random(40))]
        // );

        event(new Registered($user = $this->create($request->all()
            + [
                'password' => Str::random(40),
                'name' => Str::random(10),
                'username' => Str::random(5)
            ]
        )));

        $this->guard()->login($user);
        // dd($user);
         
        // Auth::loginUsingId($user->id);
        // $request->session()->regenerate();

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
        
        // return redirect('/home');
    }
}