<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function delete_users(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if(isset($user)){
                DB::beginTransaction();
                $user->delete();
                DB::commit();

                return response()->json([
                    'code' => 200,
                    'messages' => "Users Deleted",
                    'data' => $user
                ]);
            }

            return response()->json([
                'code' => 400,
                'messages' => "Users Not Found",
                'data' => $user
            ]);
            
        } catch (\Throwable $exception) {
            $message = array(
                "url"       => url()->current(),
                "error"     => $exception->getMessage() . " LINE : " . $exception->getLine(),
                "data"      => $request,
                "controller"=> app('request')->route()->getAction(),
            );
            Log::critical($message);
            return response()->json([
                'code' => 400,
                'message' => trans('messages.went_wrong'),
                'data' => $message
            ]);
        }
    }

    public function posts_index(Request $request)
    {
        $post = Post::with(['categories','user_posts'])->get();
        return view('admin.dashboard.posts',[
            'posts' => $post
        ]);
    }

    public function detail_posts(Request $request)
    {
        try {
            // get detail posts
            $post = Post::with(['categories','user_posts'])->where('id',$request->id)->first();
    
            if(!isset($post)){
                return response()->json([
                    'code' => 400,
                    'messages' => 'Posts not Found !',
                    'data' => null
                ]);
            }

            return response()->json([
                'code' => 200,
                'messages' => 'Request Success',
                'data' => $post
            ]);
        } catch (\Throwable $exception) {
            $message = array(
                "url"       => url()->current(),
                "error"     => $exception->getMessage() . " LINE : " . $exception->getLine(),
                "data"      => $request,
                "controller"=> app('request')->route()->getAction(),
            );
            Log::critical($message);
            return response()->json([
                'code' => 400,
                'message' => trans('messages.went_wrong'),
                'data' => $message
            ]);
        }

        

    }

    public function delete_posts(Request $request, $id)
    {
        try {
            // find posts
            $post = Post::where('id', $id)->first();
            if(isset($post)){
                $post->delete();

                return response()->json([
                    "code" => 200,
                    "messages" => 'Delete Data Success',
                    'data' => $post
                ]);
            }

            return response()->json([
                    "code" => 400,
                    "messages" => 'Delete Data Failed',
                    'data' => $post
            ]);
        } catch (\Throwable $exception) {
            $message = array(
                "url"       => url()->current(),
                "error"     => $exception->getMessage() . " LINE : " . $exception->getLine(),
                "data"      => $request,
                "controller"=> app('request')->route()->getAction(),
            );
            Log::critical($message);
            return response()->json([
                'code' => 400,
                'message' => trans('messages.went_wrong'),
                'data' => $message
            ]);
        }
    }

    public function categories_index(Request $request)
    {
        $categories = Category::all();
        return view('admin.dashboard.categories',[
            'categories' => $categories
        ]);
    }

    public function add_new_categories(Request $request)
    {
        $valdiator = Validator::make($request->all(),[
             'title' => "required"
         ],
         [
            'title.required' => 'Name is Required !'
         ]
        );
         
         if($valdiator->fails()){
             return response()->json([
                 'code' => 422,
                 'data'=> $valdiator->errors()
             ]);
         }
        try {

            DB::beginTransaction();
            $categories = new Category();
            $categories->name = $request->title;
            $categories->created_at = now();
            $categories->save();
            DB::commit();

            return response()->json([
                'code' => 200,
                'meesages' => "udpate categories Success",
                'data' => $categories
            ]);

        } catch (\Throwable $exception) {
            DB::rollBack();
            $message = array(
                "url"       => url()->current(),
                "error"     => $exception->getMessage() . " LINE : " . $exception->getLine(),
                "data"      => $request,
                "controller"=> app('request')->route()->getAction(),
            );
            Log::critical($message);
            return response()->json([
                'code' => 400,
                'message' => trans('messages.went_wrong'),
                'data' => $message
            ]);
        }
    }

    public function delete_categories(Request $request,$id)
    {
        try {
            // find categories
            $categories = Category::find($id);
            if(isset($categories)){
                DB::beginTransaction();
                $categories->delete();
                DB::commit();

                return response()->json([
                    'code' => 200,
                    'messages'=> "Categories Deleted",
                    'data' => $categories
                ]);
            }

            return response()->json([
                'code' => 400,
                'messages'=> "Posts Not Found !",
                'data' => $categories
            ]);


        } catch (\Throwable $exception) {
            DB::rollBack();
            $message = array(
                "url"       => url()->current(),
                "error"     => $exception->getMessage() . " LINE : " . $exception->getLine(),
                "data"      => $request,
                "controller"=> app('request')->route()->getAction(),
            );
            Log::critical($message);
            return response()->json([
                'code' => 400,
                'message' => trans('messages.went_wrong'),
                'data' => $message
            ]);
        }
    }
}
