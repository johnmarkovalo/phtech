<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $technology = Technology::create($request->all());
        return response(['tag' => $technology], 200);

    }

    public function update (Request $request) {
        Technology::where('id', $request->id)->update($request->toArray());
        
    }

    public function destroy (Technology $technology) {
        $technology->delete();
        
    }

    public function index (Request $request) {
        $users = User::where('user_type', 'user')->get();
        return response(['users' => $users], 200);
        // return 'fuck';
    }

}
