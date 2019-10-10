<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\User;
use App\UserType;
use App\UserInformation;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_type' => 'required|string',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:10',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user_type_id = UserType::where('name', $request['user_type'])->first()->id;
        $user = User::create(array_merge($request->toArray(), ['user_type_id' => $user_type_id]));
        $user_information = UserInformation::create(array_merge($request->toArray(), ['user_id' => $user->id]));

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token], 200);
    }

    public function login (Request $request) {
        $user = User::where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token], 200);
            } else {
                return response("Password missmatch", 422);
            }
        } else {
            return response('User does not exist', 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response('You have been succesfully logged out!', 200);
    }
}
