<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ActivationService;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected $activationService;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest')->except('logout');
        $this->activationService=$activationService;
    }

    protected function authenticated(Request $request, User $user)
    {
        if (!$user->active) {
            $this->activationService->sendActivationEmail($user);
            auth()->logout();
            return back()->with('status','Your account is not active, please check your email to activate this account');
        }
        return redirect()->intended($this->redirectPath());
    }
}
