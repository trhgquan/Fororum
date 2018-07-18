<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\UserBlacklists;
use App\UserInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
	/**
	 * __construct, in here we use the "guest" middleware
	 * just for non-logged-in users. but in case uses
	 * wanted to logout
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Log user in
	 * @param  Request $Request
	 * @return null
	 */
	public function login(Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'username' => 'required|string',
			'password' => 'required|string'
		], [
			'username.required' => 'Không được bỏ trống ô tên tài khoản!',
			'password.required' => 'Không được bỏ trống ô mật khẩu!'
		]);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
		else
		{
			if (Auth::attempt(['username' => $Request->get('username'), 'password' => $Request->get('password')], $Request->get('remember_me')))
			{
				// check for user permissions
				// so admin goes to admin, and banned goes to banned
				return $this->checkUserPermissions(Auth::id());
			}
			else
			{
				return redirect()->back()->withErrors(['username' => 'Tài khoản không chính xác', 'password' => 'Mật khẩu không chính xác'])->withInput();
			}
		}
	}

	/**
	 * Log user out of session
	 * @return null
	 */
	public function logout()
	{
		if (Auth::check())
		{
			Auth::logout();
			return redirect()->route('login')->withErrors(['title' => 'Thông báo', 'content' => 'Đã đăng xuất khỏi hệ thống thành công!', 'class' => 'info']);
		}
		return redirect()->route('login');
	}

	/**
	 * check if user get banned or user is an admin
	 * @param  int $id
	 * @return null
	 */
	protected function checkUserPermissions ($id)
	{
		$permissions = UserInformation::userPermissions($id);
		if (!$permissions['banned'])
		{
			if ($permissions['admin'])
			{
				return redirect()->route('admin.index');
			}
			return redirect()->intended('/');
		}
		else
		{
			// if user is banned,
			// log him out and tell him	why dafug he got banned.
			return $this->ifUserBanExpired($id);
		}
	}

	/**
	 * if user banned, check if his ban expired
	 * @param  int $id
	 * @return null
	 */
	protected function ifUserBanExpired ($id)
	{
		if (!UserBlacklists::checkIfExpired($id))
		{
			// now this is the reason
			$reason = UserBlacklists::reason($id);
			// now we log him out
			Auth::logout();
			return redirect()->back()->withErrors(['title' => 'Lỗi', 'content' => 'Tài khoản của bạn đã bị khóa bởi ' . User::username($reason->admin_id) . ' và sẽ được mở khóa vào lúc ' . date_format((new Carbon($reason->expire)), 'h:i:s A T, d-m-Y'), 'class' => 'danger']);
		}
		// his ban is expired. unban and redirect to home.
		UserBlacklists::unban($id);
		return redirect()->intended('/');
	}
}
