<?php

namespace App\Http\Controllers\Auth;

use App\Security\SecurityBL;
use App\Http\Controllers\Controller;
use App\Enums\LoginResult;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $result = SecurityBL::login($request->all());

        
        switch ($result) {
            case LoginResult::SUCCESS:
                return redirect('home');
            case LoginResult::INVALID_USER:
                throw ValidationException::withMessages(['email' => 'El usuario no existe.']);
                break;
            case LoginResult::INVALID_PASSWORD:
                throw ValidationException::withMessages(['password' => 'Contrase&ntilde;a incorrecta.']);
                break;
            case LoginResult::LOCKED_OUT:
                throw ValidationException::withMessages(['locked' => 'Usuario bloqueado. Contacte al administrador.']);
                break;
        }
    }
}
