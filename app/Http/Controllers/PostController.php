<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(),[
                // 'image' => "required",
                // 'title' => "required",
                // 'description' => 'required',
                // 'tags' => 'required'
        ],
        [

        ]

        );

        if($validator->fails()) {
            return response()->json([
                'code' => 422,
                'data' => $validator->errors()
            ]);
        }   
        try {
            DB::beginTransaction();
            $post = new Post();
            $post->title = $request->title;
            $post->descriptions = $request->description;
            $post->categories_id = 1;
            $post->image_path = $request->file('image')->store('assets/posts', 'public');
            $post->save();
            DB::commit();
    
            return response()->json([
                "code" => 200,
                "messages" => trans('messages.posts_success'),
                "data" => $post
            ]);
            //code...
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                "code" => 500,
                'messages'=>$e,
            ]);
        }
        
    }
}
