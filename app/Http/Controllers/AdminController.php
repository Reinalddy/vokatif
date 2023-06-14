<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin_index(Request $request)
    {
        $post = Post::all()->count();
        $user = User::all()->count();
        $categories = Category::all()->count();
        return view('admin.dashboard.dashboard',[
            'posts' => $post,
            'users' => $user,
            'categories' => $categories
        ]);
    }

    public function users_index(Request $request)
    {
        $user = User::all();
        return view('admin.dashboard.users',[
            'users' => $user
        ]);
    }

    public function posts_index(Request $request)
    {
        $post = Post::with('user_posts')->get();
        return view('admin.dashboard.posts',[
            'posts' => $post
        ]);
    }

    public function categories_index(Request $request)
    {
        $categories = Category::all();
        return view('admin.dashboard.categories',[
            'categories' => $categories
        ]);
    }
}
