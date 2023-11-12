<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Library\SendSMS;
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
            'username' => 'required|min:7|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        $user = User::where('number', $request->username)->first();
        if ($user) {
            $password = rand(111111, 999999);
            $user->password = $password;
            $user->save();
            SendSMS::sendVerification($request->username, $password);
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'your not singed in'], 400);
        };
    }

    public function verify(Request $request)
    {
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
