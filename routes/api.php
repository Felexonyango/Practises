<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);

//protected routes

Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::post('/post',[postController::class, "store"]);
    Route::delete('/post/{id}',[postController::class, "destroy"]);
    Route::put('/post/{id}',[postController::class,"update"]);
    Route::post('/logout',[UserController::class, "logout"]);
});

//public routes

Route::get('/post',[postController::class,"index"]);




