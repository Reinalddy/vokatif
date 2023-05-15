<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view (Request $request)
    {
        return view('home.index');
    }

    public function login_index(Request $request)
    {
        return view('home.login.login');
    }

    public function register_index(Request $request)
    {
        return view('home.login.register');
    }
}
