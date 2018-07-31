<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterController extends Controller
{
	/**
	 * you must be a guest.
	 * so you shall not pass!
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * register a new account.
	 * @param  Request $Request
	 * @return null
	 */
	public function register(Request $Request)
	{
		$validator = Validator::make($Request->all(), [
			'username'              => ['required','regex:/^[A-Za-z0-9._]+$/','min:6','max:20','unique:users'], // Laravel tolds me to do this so...
			'email'                 => 'required|string|email|unique:users',
			'password'              => 'required|string|min:6',
			'password_confirmation' => 'required|string|same:password',
			'agrees'                => 'accepted'
		], [
			'username.max'               => 'Độ dài quá mức cho phép!',
			'username.regex'             => 'Không đúng định dạng cho phép!',
			'username.min'               => 'Tài khoản quá ngắn!',
			'username.unique'            => 'Tài khoản đã tồn tại.',
			'email.unique'               => 'Email đã được dùng để đăng ký tài khoản.',
			'password.min'               => 'Mật khẩu không an toàn.',
			'password_confirmation.same' => 'Mật khẩu và mật khẩu nhập lại không khớp.',
			'agrees.accepted'			 => 'Bạn phải đồng ý với điều khoản dịch vụ và chính sách người dùng.'
		]);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
		else
		{
			$user = User::create([
				'username' => $Request->get('username'),
				'password' => bcrypt($Request->get('password')),
				'email'    => $Request->get('email')
			]);

			UserInformation::create([
				'id'          => $user->id,
				'permissions' => 1
			]);

			(Auth::guard())->login($user);

			return redirect()->intended('/home');
		}
	}
}
