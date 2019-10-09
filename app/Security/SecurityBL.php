<?php

namespace App\Security;

use DB;
use App\User;
use App\Enums\LoginResult;
//use \Datetime;
use Illuminate\Support\Facades\Auth;

class SecurityBL
{
  private const LOGIN_ERROR = 'Usuario o password invalido';

  public static function login(array $data) {

    

    $user = User::where('email', $data['email'])->first();

    

    if ($user === NULL) {
      return LoginResult::INVALID_USER;
    }

    if ($data['password'] != $user->password) {
        return LoginResult::INVALID_PASSWORD;
    }

    Auth::guard()->login($user);
    return LoginResult::SUCCESS;
  }
}
