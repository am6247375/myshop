<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function validateLogin(Request $request)
{
    
    $request->validate([
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'regex:/@.+\.[a-zA-Z]{1,}$/i' // التحقق من وجود نقطة بعد @
        ],
        'password' => 'required|string',
    ], [
        'email.required' => 'يرجى إدخال البريد الإلكتروني.',
        'email.string' => 'البريد الإلكتروني يجب أن يكون نصاً.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'email.regex' => 'يجب أن يحتوي البريد الإلكتروني على نقطة (.) بعد @ ويتبعها حرف واحد على الأقل.',
        'password.required' => 'يرجى إدخال كلمة المرور.',
        'password.string' => 'كلمة المرور يجب أن تكون نصاً.',
    ]);
}

 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
