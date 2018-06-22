<?php

namespace App\Http\Controllers;

use Auth;
use App\UserInformation;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

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
				$permissions = UserInformation::userPermissions(Auth::id());
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
					Auth::logout();
					return redirect()->back()->withErrors(['title' => 'Lỗi', 'content' => 'Tài khoản của bạn đã bị ban khỏi hệ thống!', 'class' => 'warning']);
				}
			}
			else
			{
				return redirect()->back()->withErrors(['username' => 'Tài khoản không chính xác', 'password' => 'Mật khẩu không chính xác'])->withInput();
			}
		}
	}

	public function logout()
	{
		if (Auth::check())
		{
			Auth::logout();
			return redirect()->route('login')->withErrors(['title' => 'Thông báo', 'content' => 'Đã đăng xuất khỏi hệ thống thành công!', 'class' => 'info']);
		}
		return redirect()->route('login');
	}
}
