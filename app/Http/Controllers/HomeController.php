<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function __construct()
	{
		$this->middleware('alive');
	}

	public function home()
	{
		return view('home');
	}
}
