<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ActivationService;
use App\Http\Requests\RegisterRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $activationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest');
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'max:50|nullable',
            'address' => 'max:100|nullable',
            'phone_number' => 'numeric|nullable',
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
            'dob' => 'date|nullable',
        ]);
    }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(RegisterRequest $registerRequest)
    {
        //set default avatar
        $filename = config('app.avatar');
        //if user does not upload avatar, use default
        $validatedData = $registerRequest->validated();
        if (isset($validatedData['avatar']) && $validatedData['avatar'] !== null) {
            $avatar = $validatedData['avatar'];
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);
        }
        return User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'name' => $validatedData['name'] === null ? $validatedData['email'] : $validatedData['name'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
            'dob' => $validatedData['dob'],
            'avatar' => $filename
        ]);
    }

    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->create($registerRequest);
        event(new Registered($user));

        $this->activationService->sendActivationEmail($user);
        Auth::logout();
        return redirect('/login')->with('status', 'Please check your email and activate your account');
    }

    public function activateUser(String $activationCode)
    {
        Auth::logout();
        if ($user = $this->activationService->activateUser($activationCode)) {
            auth()->login($user);
            return redirect('/login');
        }
        abort(404);
    }
}
