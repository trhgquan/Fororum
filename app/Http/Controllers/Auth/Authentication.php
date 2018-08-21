<?php

namespace App\Http\Controllers\Auth;

use App\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait Authentication
{
    use ThrottlesLogins, RedirectsUsers;

    protected $redirectTo = '/forum';

    /**
     * Handle user login request.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return mixed
     */
    public function login(Request $Request)
    {
        // validate login credentials
        $this->validateLogin($Request);

        // prevent brute-force attack
        if ($this->hasTooManyLoginAttempts($Request)) {
            $this->fireLockoutEvent($Request);

            return $this->sendLockoutResponse($Request);
        }

        if ($this->attemptLogin($Request)) {
            // user credentials is valid, logged in successful
            return $this->sendLoginResponse($Request);
        }
        // user credentials is invalid.
        $this->incrementLoginAttempts($Request);

        // at here we don't send the invalid username message.
        // because someone will guest the username.
        return $this->sendFailedLoginResponse($Request, ['password' => 'Please check your password again.']);
    }

    /**
     * Validate user login request.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return void
     */
    protected function validateLogin(Request $Request)
    {
        return $this->validate($Request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'You need a username to login.',
            'password.required' => 'You need a password to login.',
        ]);
    }

    /**
     * get user login credentials from the request.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return array
     */
    protected function credentials(Request $Request)
    {
        return $Request->only('username', 'password');
    }

    /**
     * Attempt to log the user in the Fororum.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return bool
     */
    protected function attemptLogin(Request $Request)
    {
        return $this->guard()->attempt($this->credentials($Request));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $Request)
    {
        // generate a new session
        $Request->session()->regenerate();

        // clear the throttle
        $this->clearLoginAttempts($Request);

        // log user out of any devices
        $this->guard()->logoutOtherDevices($this->credentials($Request)['password']);

        // redirect a user to his zone if he is a specific user.
        return $this->authenticated($Request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param Illuminate\Http\Request $Request
     * @param mixed                   $user
     *
     * @return mixed
     */
    protected function authenticated(Request $Request, $user)
    {
        $user = UserInformation::userPermissions($user->id);

        // redirect the admins to the Admin Dashboard.
        if ($user['admin']) {
            return redirect()->route('admin.home');
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param Illuminate\Http\Request $Request
     * @param array                   $message
     *
     * @return Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $Request, array $message)
    {
        throw ValidationException::withMessages($message);
    }

    /**
     * Log user out of Fororum.
     *
     * @param Illuminate\Http\Request $Request
     * @param array                   $logoutMessage
     *
     * @return Illuminate\Http\Response
     */
    public function logout(Request $Request, $logoutMessage = ['title' => 'Logged out', 'content' => 'You are now logged out.', 'class' => 'info'])
    {
        // log user out of Fororum.
        $this->guard()->logout();

        // invalidate the session.
        $Request->session()->invalidate();

        // and finally redirect him back to the login page, with the message.
        return redirect()->route('auth.login')->withErrors($logoutMessage);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
