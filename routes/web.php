<?php

use App\Http\Controllers\AdminController;
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

  Route::get('/forgot-password',[LoginController::class, 'forgot_password_index']);
  Route::post('/forgot-password',[LoginController::class, 'forgot_password']);
});

Route::middleware('login')->group(function() {
  Route::post('/logout',[LoginController::class,'logout']);

  Route::get('/profile', [HomeController::class, 'profile_index']);
  Route::post('/profile', [HomeController::class, 'profile_update']);
  Route::post('/profile/data', [HomeController::class, 'profile_update_data']);

  Route::get('/my-posts', [HomeController::class, 'my_posts_index']);

  Route::post('/upload',[PostController::class,'post']);

  Route::middleware('admin')->group(function () {
    Route::get('/dashboard',[AdminController::class,'admin_index']);
    Route::get('/dashboard/users',[AdminController::class,'users_index']);
    Route::get('/dashboard/posts',[AdminController::class,'posts_index']);
    Route::get('/dashboard/categories',[AdminController::class,'categories_index']);
  });
  
});
