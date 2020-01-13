<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\Technology;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TechnologyController extends Controller
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
        $technology = Technology::where('status', 'ACTIVE')->get();
        $tags = [];
        foreach($technology as $tag ){
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'description' => $tag->description,
            ];
        }
        return response(['tags' => $tags], 200);
    }

    public function saveNew (Request $request) {

        $NewTags  = $request->newTags;
        $technology = [];
        foreach($NewTags as $tag){
            $technology[] = Technology::create(['name' => $tag['name'], 'description' => null]);
        }
        return response(['tag' => $technology], 200);

    }

}
