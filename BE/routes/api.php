<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'email|required|max:200',
        'password' => 'required|min:7'
    ]);

    if (!$credentials) {
        return response()->json(['status' => false, 'message' => 'invalid credentials!'], 401);
    } else {
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        if ($user) {
            return response()->json(['status' => true, 'message' => 'successfully created!'], 201);
        } else {
            return response()->json(['status' => false, 'message' => "can't set in the database!"], 401);
        }
    }
});

Route::post('/login', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'username' => 'email|required|min:7|max:200',
        'password' => 'required|min:7'
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors()->first() , 422);
    }
    $username = $request->username;
    $password = $request->password;
    $clientSecret = DB::table('oauth_clients')->where('id', 2)->value('secret');
    
    $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
        'grant_type' => 'password',
        'client_id' => '2',
        'client_secret' => $clientSecret,
        'username' => $username,
        'password' => $password,
        'scope' => '',
    ]);

    return $response->json();
});
