<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
        protected $redirectTo = '/';

      public function showResetForm(Request $request, $token = null)
      {
        $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image blank-page','navbarType'=>'hidden'];

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'pageConfigs' => $pageConfigs]
        );
      }
}