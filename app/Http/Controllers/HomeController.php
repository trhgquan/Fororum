<?php

namespace App\Http\Controllers;

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
