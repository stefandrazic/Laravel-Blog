<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});


Route::resource('/auth', 'App\Http\Controllers\AuthController');
Route::resource('/posts', 'App\Http\Controllers\PostsController');
Route::resource('/comments', 'App\Http\Controllers\CommentsController');

Route::middleware('notauthenticated')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::get('/register', [AuthController::class, 'showRegister']);
});

Route::middleware('authenticated')->group(function () {
    Route::get('/createpost', [PostsController::class, 'createPost']);
    Route::get('logout', [AuthController::class, 'destroy']);
    Route::get('/changepassword', [AuthController::class, 'showChangePassword']);
    Route::post('/changepassword', [AuthController::class, 'changePassword']);
});
