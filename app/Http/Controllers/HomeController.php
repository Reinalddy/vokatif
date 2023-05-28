<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Cache\RedisStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function view (Request $request)
    {
        // get data login user
        $data = Auth::user();
        if($data) {
            $user = DB::table('users')->where('email', $data->email)->first();
        }
        else {
            // set var user to be null if user not login
            $user = null;
        }
        if($user) {
            $status = 'login';
        } else {
            $status = 'not_login';
        }
        return view('home.index',[
            "user" => $user,
            "status" => $status
        ]);
    }

    public function profile_index(Request $request)
    {
        $user = Auth::user();
        
        return view('profile.index', [
            'user' => $user
        ]);
    }
}
