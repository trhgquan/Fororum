<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFollowers;
use App\UserInformation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('alive');
	}

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

	public function profile ($username)
	{
		$user = User::profile($username);
		$userInformation = UserInformation::userPermissions($user->id);
		if ($user->id == Auth::id())
		{
			return redirect('/user/profile');
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

	public function edit()
	{
		return view('profile', ['edit' => true]);
	}

	public function donate($username)
	{
		return view('donate', ['username' => $username]);
	}

	public function editPassword(Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'password' => 'string|required',
			'new_password' => 'string|required|min:6',
			'password_confirmation' => 'string|required|same:new_password'
		], [
			'password.required' => 'Không được để trống ô mật khẩu!',
			'new_password.required' => 'Không được để trống ô mật khẩu mới!',
			'password_confirmation.required' => 'Không được để trống ô xác nhận mật khẩu!',
			'new_password.min' => 'Mật khẩu không an toàn!',
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
				return redirect()->route('edit')->withErrors(['title' => 'Thông báo', 'content' => 'Đã cập nhật mật khẩu mới thành công!', 'class' => 'success']);
			}
			else
			{
				return redirect()->back()->withErrors(['title' => 'Lỗi', 'content' => 'Mật khẩu hiện tại của bạn không chính xác!', 'class' => 'danger'])->withInput();
			}
		}
	}

	public function follow (Request $Request)
	{
		$id = $Request->get('uid');
		if ($id !== Auth::id() && User::exist($id) && !UserInformation::userPermissions($id)['banned'])
		{
			UserFollowers::follow(Auth::id(), $id);
		}
		return redirect()->back();
	}
}
