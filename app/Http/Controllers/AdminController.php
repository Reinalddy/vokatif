<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin_index(Request $request)
    {
        return view('admin.dashboard.dashboard');
    }

    public function users_index(Request $request)
    {
        return view('admin.dashboard.users');
    }

    public function posts_index(Request $request)
    {
        return view('admin.dashboard.posts');
    }

    public function categories_index(Request $request)
    {
        return view('admin.dashboard.categories');
    }
}
