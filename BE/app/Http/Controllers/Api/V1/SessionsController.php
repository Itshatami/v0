<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SessionsController extends Controller
{
    public function auth(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'email|required|min:7|max:200',
            'password' => 'required|min:7'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
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
    }
}
