<?php

namespace App\Http\Controllers;

use App\Mail\recoverPassword;
use App\User;
use App\UserBlacklists;
use App\UserInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Auth\Authentication;

class AuthController extends Controller
{
    use Authentication;

    protected $redirectTo = '/forum';

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

            // log user in after register successful!
            Auth::login($user);
            // and then redirect him to homepage
            return redirect()->intended('/home');
        }
    }

    /**
     * request to recover an account
     * @param  Illuminate\Http\Request $Request
     * @return Illuminate\Http\Response
     */
    public function recoverRequest(Request $Request)
    {
        $validator = Validator::make($Request->only('email'), [
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'The email field is required',
            'email.email'    => 'The email field must contains a valid email address',
            'email.exists'   => 'This email does not exists in our database.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Mail::to($Request['email'])->send(new recoverPassword('You have requested a new password. Click here to reset your password. If you did not take this action, please do not click the link above.'));

        return redirect()->back()->withErrors(['success' => 'An email has been sent to '.$Request['email']]);
    }
}
