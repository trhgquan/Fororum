<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFollowers;
use App\UserNotification;
use App\UserInformation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
	/**
	 * when user click on the navbar's dropdown
	 * and get to the first page, this is it.
	 * @return null
	 */
	public function home()
	{
		$user = Auth::user();
		$userInformation = UserInformation::userPermissions($user->id);
		return view('profile',
			[
				'edit' => false,
				'this_profile' => true,
				'content' => [
					'user_content' => $user,
					'history'      => User::userPosts($user->id)
				]
			]
		);
	}

	/**
	 * when user access another user's profile, here it is.
	 * if user access his own profile, redirect back to home.
	 * @param  string $username no id, because user can register with a digits-string
	 * @return null
	 */
	public function profile ($username)
	{
		$user = User::profile($username);
		$userInformation = UserInformation::userPermissions($user->id);
		if ($user->id == Auth::id())
		{
			return redirect()->route('user.profile.home');
		}
		return view('profile',
			[
				'edit' => false,
				'this_profile' => false,
				'content' => [
					'user_content' => $user,
					'history'      => User::userPosts($user->id)
				]
			]
		);
	}

	/**
	 * when user click on the navbar's dropdown
	 * and get to the edit page, this is it.
	 * @return null
	 */
	public function edit()
	{
		return view('profile', ['edit' => true]);
	}

	/**
	 * EDIT USER'S PASSWORD
	 * @param  Request $Request
	 * @return null
	 */
	public function editPassword(Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'password' => 'string|required',
			'new_password' => 'string|required|min:6|different:password',
			'password_confirmation' => 'string|required|same:new_password'
		], [
			'password.required' => 'Không được để trống ô mật khẩu!',
			'new_password.required' => 'Không được để trống ô mật khẩu mới!',
			'new_password.different' => 'Mật khẩu mới không được trùng với mật khẩu cũ!',
			'new_password.min' => 'Mật khẩu không an toàn!',
			'password_confirmation.required' => 'Không được để trống ô xác nhận mật khẩu!',
			'password_confirmation.same' => 'Mật khẩu mới và mật khẩu xác nhận không khớp với nhau!'
		]);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator);
		}
		else
		{
			$user_password = Auth::user()->password;
			if (Hash::check($Request->get('password'), $user_password))
			{
				$userObj = User::find(Auth::id());
				$userObj->password = bcrypt($Request->get('new_password'));
				$userObj->save();
				return redirect()->route('user.edit')->withErrors(['title' => 'Thông báo', 'content' => 'Đã cập nhật mật khẩu mới thành công!', 'class' => 'success']);
			}
			else
			{
				return redirect()->back()->withErrors(['password' => 'Mật khẩu hiện tại của bạn không chính xác!'])->withInput();
			}
		}
	}

	/**
	 * follow another profile
	 * @param  Request $Request
	 * @return null
	 */
	public function follow (Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'uid' => 'required|numeric'
		]);
		if (!$validator->fails())
		{
			$id = (int) $Request->get('uid');
			if ($id !== Auth::id() && User::exist($id) && !UserInformation::userPermissions($id)['banned'])
			{
				UserFollowers::follow(Auth::id(), $id);
				// if 2 user are not followed before, send a notification
				// if not, unfollow in silence
				if (UserFollowers::is_followed(Auth::id(), $id))
				{
					UserNotification::create([
						'user_id' => $id,
						'participant_id' => Auth::id(),
						'route' => 'profile',
						'content' => User::username(Auth::id()) . ' vừa đăng ký bạn!'
					]);
				}
			}
		}
		return redirect()->back();
	}
}
