<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin_index(Request $request)
    {
        return view('admin.dashboard.dashboard');
    }
}
