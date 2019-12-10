<?php

namespace App\Http\Controllers\Auth;

use App\EmailLogin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

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
        $this->validate($request, ['email' => 'required|email|exists:penpals']);

        $email = $request->input('email');
        $emailLogin = EmailLogin::createForEmail($email);

        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($email) {
//            $m->from('noreply@penpalsforyang.com', 'PenPals for Yang');
            $m->to($email)->subject('PenPals for Yang');
        });

        return view('auth.login-sent', compact('email'));
    }

    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->penpal);

        return redirect('home');
    }
}
