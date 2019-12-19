<?php

namespace App\Http\Controllers\Auth;

use App\EmailLogin;
use App\Events\PenpalVerified;
use App\Http\Controllers\Controller;
use App\Penpal;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Mail;

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
    protected $redirectTo = '/penpals';

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

        $url = $this->buildLoginLink($emailLogin->token, $request->input('remember'));

        Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($email) {
            $m->to($email)->subject('PenPals for Yang Login');
        });

        return view('auth.login-sent', compact('email'));
    }

    public function authenticateEmail($token, $remember = false)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->penpal, $remember);

        /** @var Penpal $penpal */
        $penpal = Auth::user();
        if ($penpal && !$penpal->email_verified_at) {
            event(new PenpalVerified($penpal));
        }

        $emailLogin->delete(); // only allow one login

        return redirect($this->redirectTo);
    }

    private function buildLoginLink($token, $remember)
    {
        $params = ['token' => $token];
        if ($remember) {
            $params['remember'] = 'remember';
        }

        return route('auth.email-authenticate', $params);
    }
}
