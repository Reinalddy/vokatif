<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Cache\RedisStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function view (Request $request)
    {
        // get data login user
        $data = Auth::user();
        $post = Post::with('user_posts')->get();
        $banner_post = Post::paginate(3);
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
            "status" => $status,
            "post" => $post,
            'banner_post' => $banner_post
        ]);
    }
    
    public function creatifity_index(Request $request)
    {
        $data = Auth::user();
        $post = Post::with('user_posts')->get();
        $banner_post = Post::with('user_posts')->where('target','heading')->first();
        $user = Auth::user();

        return view('home.creatifity',[
            'user' => $user,
            'banner_post'=> $banner_post,
            'post' => $post
        ]);
    }

    public function about_us_index(Request $request)
    {
        $user = Auth::user();

        return view('home.about-us',[
            'user' => $user
        ]);
    }

    public function profile_index(Request $request)
    {
        $user = Auth::user();
        
        return view('profile.index', [
            'user' => $user
        ]);
    }

    public function profile_update(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();

            // find user
            $user_data = User::where('id',$user->id)->first();
            $user_data->profile_path = $request->file('image')->store('assets/profile_image', 'public');
            $user_data->save();

            DB::commit();
            return response()->json([
                "code" => 200,
                "messages" => trans('messages.update_profile_success'),
                "data" => $user_data
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                "code" => 500,
                'messages'=>$e,
            ]);
        }
    }

    public function profile_update_data(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => "required",
            'username' => "required",
            'email' => "required",
            'password' => "required",
            'old_password'=> "required",
        ],[
            "name.required" => 'name cannot be empty!',
            "username.required" => 'username cannot be empty',
            "email.required" => 'email cannot be empty',
            "password.required" => 'password cannot be empty',
            "old_password.required" => 'old_password cannot be empty',

        ]
    
    );
        
        if($validator->fails()) {
            return response()->json([
                'code' => 422,
                'data' => $validator->errors()
            ]);
        }
        try {
            $email = $request->email;
            $name = $request->name;
            $username = $request->username;

            $user = User::where('email', $email)->first();
            if(isset($email)) {
                $user->email = $email;
            }
            if(isset($name)) {
                $user->name = $name;
            }
            if(isset($username)) {
                $user->username = $username;
            }

            if(Hash::check($request->old_password, $user->password)) {
                $user->password = bcrypt($request->password);
            } else {
                return response()->json([
                    'code' => 400,
                    'messages' => trans('messages.old_password_not_match')
                ]);
            }
            $user->save();

            DB::commit();
            return response()->json([
                "code" => 200,
                "messages" => trans('messages.update_profile_success'),
                "data" => $user
            ]);

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                "code" => 500,
                'messages'=>$e->getMessage(),
            ]);
        }
    }

    public function my_posts_index(Request $request){
        $user = Auth::user();

        return view('profile.my-posts',[
            'user' => $user
        ]);
    }

    public function detail_posts(Request $request, $id)
    {
        $user = Auth::user();
        // search posts
        $post = Post::find($id);

        return view('home.detail',[
            'user' => $user,
            'post' => $post
        ]); 
    }
}
