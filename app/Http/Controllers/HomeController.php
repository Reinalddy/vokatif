<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RedisStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        $user = Auth::getUser();
        if($user) {
            return redirect('/');
        }
        else {
           return redirect('/login')->with(['error' => 'Pesan Error']);
        }
    }
}
