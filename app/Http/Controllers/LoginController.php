<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function login_index(Request $request)
    {
        return view('home.login.login');
    }

    public function register_index(Request $request)
    {
        return view('home.login.register');
    }

    public function register(Request $request)
    {
        // validatated user input
        $validator = Validator::make($request->all(),[
            "email" => ['required','email','unique:users'],
            "name" => ['required','max:255'],
            "username" => ['required','max:255','unique:users'],
            'password' => ['required', Password::min(8)],
        ],
        [
            "email.unique" => 'Email alredy used please use another email',
            "username.unique" => 'Username alredy used please use another username'
        ]
    
    
    );

        if($validator->fails()) {
            return response()->json([
                'code' => 422,
                'data' => $validator->errors()
            ]);
        }
        try {
            //code...
            // begin input user request to database
            DB::beginTransaction();
            $default_profile_path = url('/img/profile_default.jpg');
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->remember_token = '';
            $user->created_at = now();
            $user->role_id = 2;
            $user->profile_path = $default_profile_path;
            $user->save();
            DB::commit();
            return response()->json([
                'code' => 200,
                'data' => $user,
                'messages' => trans('messages.register_success'),
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                "code" => 500,
                'messages'=>$e,
            ]);
            
        }
    }

    public function login(Request $request)
    {
        try {
            //code...
            // check user input data and data in db match or not
            $credentials = $request->only('email','username','password');
            $user = User::where('email', $request->email)->get();
            if($user){
                if(Auth::attempt($credentials)) {
                    return response()->json([
                        'code' => 200,
                        'data' => $user,
                        'messages' => trans('messages.login_success')
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 400,
                    'messages'=>trans('messages.credentials_wrong')
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 500,
                'messages'=> $e
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            //destroy session user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return response()->json([
                'code' => 200,
                'messages' => trans('messages.logout')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'messages' => $e
            ]);
        }
    }
}
