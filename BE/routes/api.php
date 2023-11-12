<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\SessionsController;
use App\Http\Controllers\LikeController;
use App\Library\SendSMS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
});

// authentication
Route::post('/register', RegisterController::class);
Route::post('/login', [SessionsController::class, 'auth']);
Route::post('/verify', [SessionsController::class, 'verify']);

// posts
Route::middleware('auth:api')->apiResource('posts', PostController::class);
Route::middleware('auth:api')->get('public/posts', [PostController::class, 'public']);

// likes
Route::middleware('auth:api')->apiResource('likes', LikeController::class);
Route::middleware('auth:api')->post('likes/{postId}', [LikeController::class, 'setLike']);
