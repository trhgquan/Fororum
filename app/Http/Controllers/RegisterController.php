<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
    /**
     * you must be a guest.
     * so you shall not pass!
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * register a new account.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function register(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'username'              => ['required', 'regex:/^[A-Za-z0-9._]+$/', 'min:10', 'max:20', 'unique:users'], // Laravel tolds me to do this so...
            'email'                 => 'required|string|email|unique:users',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
            'agrees'                => 'accepted',
        ], [
            'username.max'               => 'The username is too long.',
            'username.min'               => 'The username is too short.',
            'username.regex'             => 'The username is using some unknown characters.',
            'username.unique'            => 'This username has already been taken.',
            'email.unique'               => 'This email has already been registered.',
            'password.min'               => 'The password is too short.',
            'password_confirmation.same' => 'The password confirmation does not match.',
            'agrees.accepted'			         => 'You must agreed to the TERMS OF SERVICE and the USER AGREEMENT.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::create([
                'username' => $Request->get('username'),
                'password' => bcrypt($Request->get('password')),
                'email'    => $Request->get('email'),
            ]);

            UserInformation::create([
                'id'          => $user->id,
                'permissions' => 1,
            ]);

            Auth::login($user);

            return redirect()->intended('/home');
        }
    }
}
