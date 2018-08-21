<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Authentication;

class LoginController extends Controller
{
    use Authentication;

    protected $redirectTo = '/forum';
}
