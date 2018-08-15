<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFollowers;
use App\UserInformation;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * when user access another user's profile, here it is.
     * if user access his own profile, redirect back to home.
     *
     * @param string $username no id, because user can register with a digits-string
     *
     * @return null
     */
    public function profile($username)
    {
        $user = User::profile($username);
        $userInformation = UserInformation::userPermissions($user->id);

        return view('profile',
            [
                'edit'         => false,
                'this_profile' => $this->thisProfile($user->id),
                'content'      => [
                    'user_content' => $user,
                    'history'      => User::userPosts($user->id),
                ],
            ]
        );
    }

    /**
     * when user click on the navbar's dropdown
     * and get to the edit page, this is it.
     *
     * @return null
     */
    public function edit()
    {
        return view('profile', ['edit' => true]);
    }

    /**
     * EDIT USER'S PASSWORD.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function editPassword(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'password'              => 'string|required',
            'new_password'          => 'string|required|min:6|different:password',
            'password_confirmation' => 'string|required|same:new_password',
        ], [
            'password.required'              => 'Current password required.',
            'new_password.required'          => 'The new password goes here.',
            'new_password.different'         => 'The new password must be different from the current password.',
            'new_password.min'               => 'The new password\'s length must be at least 6 characters.',
            'password_confirmation.required' => 'The new password must be confirmed.',
            'password_confirmation.same'     => 'The password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            $user_password = Auth::user()->password;
            if (Hash::check($Request->get('password'), $user_password)) {
                $this->changeUserPassword(User::find(Auth::id()), $Request->get('new_password'));

                return redirect()->route('user.edit')->withErrors(['class' => 'success', 'title' => 'Success!', 'content' => 'Your password has been updated!']);
            } else {
                return redirect()->back()->withErrors(['password' => 'Your current password is incorrect.'])->withInput();
            }
        }
    }

    /**
     * follow another profile.
     *
     * @param Illuminate\Http\Request $Request
     *
     * @return null
     */
    public function follow(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'uid' => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            $id = (int) $Request->get('uid');
            if ($this->followable($id)) {
                UserFollowers::follow(Auth::id(), $id);
                // if 2 user are not followed before, send a notification
                // if not, unfollow in silence
                if (UserFollowers::is_followed(Auth::id(), $id)) {
                    $this->sendNotification(User::find($id));
                }
            }
        }

        return redirect()->back();
    }

    /**
     * method thisProfile
     * return true if id = profile id.
     *
     * @param int $id
     *
     * @return bool
     */
    protected function thisProfile(int $id)
    {
        return Auth::id() === $id;
    }

    /**
     * method followable
     * return true if this profile is able to follow.
     *
     * @param int $id
     *
     * @return bool
     */
    protected function followable(int $id)
    {
        return $id !== Auth::id() && User::exist($id) && !UserInformation::userPermissions($id)['banned'];
    }

    /**
     * this method change user password.
     * @param  App\User   $user
     * @param  string $password
     * @return mixed
     */
    protected function changeUserPassword (User $user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();

        // now we log user in again to prevent user being logged out
        // since we use the method AuthenticateSession.
        return Auth::login($user);
    }

    /**
     * send a notification to user
     *
     * @param  App\User   $user
     * @return mixed
     */
    protected function sendNotification (User $user)
    {
        return $user->notify(new UserNotification([
            'route' => 'user.profile.username',
            'param' => Auth::user()->username,
            'content' => Auth::user()->username . ' is following you!',
            'from'    => Auth::user()->username
        ]));
    }
}
