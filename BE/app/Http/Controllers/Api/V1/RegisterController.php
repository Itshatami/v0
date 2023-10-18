<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|max:200',
            'password' => 'required|min:7'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
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
}
