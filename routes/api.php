<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:sanctum'], function (){
    Route::post("/post", [\App\Http\Controllers\Post\PostController::class, 'store']);
    Route::post('/post_image', [\App\Http\Controllers\PostImage\PostImageController::class, 'store']);
    Route::post('/delete_post_image', [\App\Http\Controllers\PostImage\PostImageController::class, 'deletePostImage']);
    Route::get('/get_all_post', [\App\Http\Controllers\Post\PostController::class, 'index']);
    Route::get('/users', [\App\Http\Controllers\User\UserController::class, 'index']);
    Route::get('/users/{user}/posts', [\App\Http\Controllers\User\UserController::class, 'getPosts']);
    Route::get('/get_users', [\App\Http\Controllers\User\UserController::class, 'getSubscriptions']);
    Route::get('/get_news', [\App\Http\Controllers\User\UserController::class, 'getNews']);
    Route::post('/add_followings', [\App\Http\Controllers\User\UserController::class, 'addFollowings']);
    Route::post('/add_liked', [\App\Http\Controllers\User\UserController::class, 'addLiked']);
    Route::post('/posts/repost', [\App\Http\Controllers\Post\PostController::class, 'repost']);
    Route::post('/posts/comment', [\App\Http\Controllers\Post\PostController::class, 'addComment']);
    Route::post('/post/comments', [\App\Http\Controllers\Post\PostController::class, 'getComment']);
    Route::post('/add_answer', [\App\Http\Controllers\Post\PostController::class, 'addAnswer']);

});
