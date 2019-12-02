<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\User;
use App\Information;
use App\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'user_type' => 'required|string|max:255',
        ]);
        
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());
        $information = Information::create(array_merge($request->toArray(),["user_id"=>$user->id, "firstname"=>$request->firstname, "lastname"=>$request->lastname]));
        $points = Point::create(array_merge($request->toArray(),["user_id"=>$user->id, "points"=>'0']));
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token], 200);

    }

    public function login (Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token, 'user' => $user->id, 'type' => $user->user_type, 'avatar' => $user->information->avatar], 200);
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
