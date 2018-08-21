<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

trait RegistersUsers
{
    /**
     * Handle a registration request for the application
     *
     * @param  Illuminate\Http\Request $Request
     * @return Illuminate\Http\Response
     */
    public function register(Request $Request)
    {
        // validate the registration request.
        $this->validateRegistrationRequest($Request);

        // the registration request is valid. add user records into the database
        $user = $this->addRecords($Request);

        // send him a verification email.
        $user->sendEmailVerificationNotification();

        // log him in.
        $this->guard()->login($user);

        // and then redirect him to the registered page.
        return $this->registered($Request, $this->guard()->user())
                   ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Redirect the registered user to the homepage.
     *
     * @param  Illuminate\Http\Request $Request
     * @param  mixed                   $user
     *
     * @return Illuminate\Http\Response
     */
    protected function registered(Request $Request, $user)
    {
        return redirect()->route('verification.notice');
    }

    /**
     * Validate the registration request.
     *
     * @param  Illuminate\Http\Request $Request [description]
     * @return void
     */
    protected function validateRegistrationRequest(Request $Request)
    {
        return $this->validate($Request, [
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
           'agrees.accepted'			=> 'You must agreed to the TERMS OF SERVICE and the USER AGREEMENT.',
        ]);
    }

    /**
     * Get the account credentials from the registration to insert into User.
     *
     * @param  Illuminate\Http\Request $Request
     * @return array
     */
    protected function accountCredentials(Request $Request)
    {
        return $Request->only('username', 'password', 'email');
    }

    /**
     * Add a user record to database tables.
     *
     * @param Illuminate\Http\Request $Request
     * @return App\User
     */
    protected function addRecords(Request $Request)
    {
        // first we create the user.
        $user = $this->create($this->accountCredentials($Request));

        // then, we update his information
        $this->update($user);

        // finally, return his credentials.
        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Array  $data
     * @return App\User
     */
    protected function create(Array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email'    => $data['email'],
        ]);
    }

    /**
     * Update user information into a UserInformation instance
     *
     * @param  App\User   $user
     * @return App\UserInformation
     */
    protected function update(User $user)
    {
        return UserInformation::create([
            'id'           => $user->id,
            'permissions'  => 1,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
