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

class AuthController extends Controller
{
    /**
     * __construct, in here we use the "guest" middleware
     * just for non-logged-in users. but in case uses
     * wanted to logout.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log user in.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function login(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'The username field is required.',
            'password.required' => 'The password field is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            return $this->logUserIn($Request->all());
        }
    }

    /**
     * Log user out of session.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function logout(Request $Request)
    {
        if (Auth::check()) {
            Auth::logout();
            // this line support Auth::logoutOtherDevices()
            // prevent the cannot-log-in bug.
            $Request->session()->flush();

            return redirect()->route('login')->withErrors(['title' => 'Logged out', 'content' => 'You are now logged out.', 'class' => 'info']);
        }

        return redirect()->route('login');
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

            // log user in after register successful!
            Auth::login($user);
            // and then redirect him to homepage
            return redirect()->intended('/home');
        }
    }

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

    /**
     * this method log user in.
     *
     * @param array $credentials
     *
     * @return object
     */
    protected function logUserIn(array $credentials)
    {
        if ($this->attemptToLogin($credentials)) {
            // log user out of any devices
            Auth::logoutOtherDevices($credentials['password']);
            // check for user permissions
            // so admin goes to admin, and banned goes to banned
            return $this->checkUserPermissions(Auth::id());
        } else {
            return redirect()->back()->withErrors(['username' => 'Please check your username again.', 'password' => 'Please check your password again.'])->withInput();
        }
    }

    /**
     * a cut of login attempt.
     *
     * @param array $credentials
     *
     * @return object
     */
    protected function attemptToLogin(array $credentials)
    {
        return Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]);
    }

    /**
     * check if user get banned or user is an admin.
     *
     * @param int $id
     *
     * @return null
     */
    protected function checkUserPermissions($id)
    {
        $permissions = UserInformation::userPermissions($id);
        if (!$permissions['banned']) {
            if ($permissions['admin']) {
                return redirect()->route('admin.home');
            }

            return redirect()->intended('/');
        } else {
            // if user is banned,
            // log him out and tell him	why dafug he got banned.
            return $this->ifUserBanExpired($id);
        }
    }

    /**
     * if user banned, check if his ban expired.
     *
     * @param int $id
     *
     * @return null
     */
    protected function ifUserBanExpired($id)
    {
        if (!UserBlacklists::checkIfExpired($id)) {
            // now this is the reason
            $reason = UserBlacklists::reason($id);
            // now we log him out
            Auth::logout();

            return redirect()->back()->withErrors(['title' => 'Error', 'content' => 'Your account has been banned by  '.User::username($reason->admin_id).'. Date the ban will be lifted: '.date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'danger'])->withInput();
        }
        // his ban is expired. unban and redirect to home.
        UserBlacklists::unban($id);

        return redirect()->intended('/');
    }
}
