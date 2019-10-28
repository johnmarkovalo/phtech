<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Technology;
use App\Community;
use App\community_tech;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'organizer_id' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $community = Community::create($request->all());
        return response(['community' => $community], 200);

    }
    
    public function update (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $community = Community::where('user_id', $request->user_id)->first()->update($request->toArray());

        return response(['community' => $community], 200);
    }

    public function communitytech (Request $request) {
        community_tech::where('community_id', $request->id)->delete();
        $tags_tmp = $request->tags;
        foreach($tags_tmp as $tag)
        {
            $tech_id = Technology::where('name', $tag)->first()->id;
            community_tech::create(['community_id' => $request->id, 'tech_id' => $tech_id]);
        }
    }

    public function destroy (Technology $community) {
        $community->delete();
    }

    public function index (Request $request) {
        $community_tmp = Community::all();
        $communitylist = [];
        foreach($community_tmp as $community){
            $communitylist[] = [
                'id' => $community->id,
                'name' => $community->name,
                'description' => $community->description,
                'photo' => $community->photo,
                'location' => $community->location,
                'tags' => community_tech::select('technology.name')
                        ->join('technology', 'community_tech.tech_id', 'technology.id')
                        ->where('community_id', $community->id)->get(),
            ];
        }
        return response(['community' => $communitylist], 200);
    }

    public function uploadprofile(request $request){
        $user = User::findOrFail($request->id);
        if($request['nopic']==false){
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/profiles/']);
            $request['photo'] = Cloudder::getPublicId();
        }
    }
}
