<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/email/verify';
}
