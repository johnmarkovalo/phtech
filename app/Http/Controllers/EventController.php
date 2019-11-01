<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Technology;
use App\Community;
use App\Event;
use App\event_community;
use App\event_tech;
use App\user_community;
use App\user_event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string|max:255',
            'organizer_id' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $event = Event::create($request->all());
        user_event::create(['user_id' => $request->organizer_id, 'event_id' => $event->id, 'position' => 'organizer']); 
        return response(['event' => $event], 200);

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

    public function eventtech (Request $request) {
        event_tech::where('event_id', $request->id)->delete();
        $tags_tmp = $request->tags;
        foreach($tags_tmp as $tag)
        {
            $tech_id = Technology::where('name', $tag)->first()->id;
            event_tech::create(['event_id' => $request->id, 'tech_id' => $tech_id]);
        }
    }

    public function eventcommunity (Request $request) {
        event_community::where('event_id', $request->id)->delete();
        //for organizer
        $community = Community::where('name', $request->community)->first()->id;
        event_community::create(['event_id' => $request->id, 'community_id' => $community, 'position' => 'organizer']); 
        //for partner
        $partners_tmp = $request->partners;
        foreach($partners_tmp as $partner)
        {
            $community_id = Community::where('name', $partner)->first()->id;
            event_community::create(['event_id' => $request->id, 'community_id' => $community_id, 'position' => 'partner']);
        }
    }

    public function destroy (Event $event) {
        $event->delete();
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

    public function communitydetails(Request $request) {
        $community = Community::where('name', $request->name)->first();
        $communitydetails = [
            'id' => $community->id,
            'name' => $community->name,
            'location' => $community->location,
            'photo' => $community->photo,
            'organizer' => $community->organizer->name,
        ];

        $members_tmp = user_community::where('community_id', $community->id)->get();
        $members = [];
        foreach($members_tmp as $member){
            $members[] = [
                'id' => $member->user->id,
                'name' => $member->user->name,
                'position' => $member->position,
                'avatar' => $member->user->information->avatar,
            ];
        }
        // return response(['community' => $members_tmp], 200)
        return response(['community' => $communitydetails,'members' => $members], 200);
    }

    public function uploadprofile(request $request){
        $user = User::findOrFail($request->id);
        if($request['nopic']==false){
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/profiles/']);
            $request['photo'] = Cloudder::getPublicId();
        }
    }
}
