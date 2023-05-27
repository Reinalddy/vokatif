<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

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

Route::middleware('public')->group(function(){
  Route::get('/login',[LoginController::class, 'login_index']);
  Route::post('/login',[LoginController::class, 'login']);
  
  Route::get('/register',[LoginController::class, 'register_index']);
  Route::post('/register',[LoginController::class, 'register']);
  Route::post('/logout',[LoginController::class,'logout']);
});

Route::middleware('login')->group(function() {
  Route::get('/profile', [HomeController::class, 'profile_index']);
});

