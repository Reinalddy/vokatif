<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class,'view']);
Route::get('/creatifity',[HomeController::class,'creatifity_index']);
Route::get('/about-us',[HomeController::class,'about_us_index']);

Route::middleware('public')->group(function(){
  Route::get('/login',[LoginController::class, 'login_index']);
  Route::post('/login',[LoginController::class, 'login']);
  
  Route::get('/register',[LoginController::class, 'register_index']);
  Route::post('/register',[LoginController::class, 'register']);
});

Route::middleware('login')->group(function() {
  Route::post('/logout',[LoginController::class,'logout']);
  Route::get('/profile', [HomeController::class, 'profile_index']);
  Route::get('/my-posts', [HomeController::class, 'my_posts_index']);

  Route::post('/upload',[PostController::class,'post']);
});

