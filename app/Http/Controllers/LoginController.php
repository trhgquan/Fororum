<?php

namespace App\Http\Controllers;

use App\User;
use App\UserBlacklists;
use App\UserInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
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
