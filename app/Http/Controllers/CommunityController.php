<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Technology;
use App\Community;
use App\community_tech;
use App\user_community;
use App\user_event;
use App\event_community;
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
        user_community::create(['user_id' => $request->organizer_id, 'community_id' => $community->id, 'position' => 'organizer']);
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

    public function destroy (Community $community) {
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

    public function communitydetails(Request $request) {
        $membership = '';
        $community = Community::where('name', $request->name)->first();
        $communitydetails = [
            'id' => $community->id,
            'name' => $community->name,
            'location' => $community->location,
            'photo' => $community->photo,
            'description' => $community->description,
            'organizer' => $community->organizer->name,
            'tags' => community_tech::select('technology.name')
                        ->join('technology', 'community_tech.tech_id', 'technology.id')
                        ->where('community_id', $community->id)->get(),
        ];

        $members_tmp = user_community::where('community_id', $community->id)->get();
        $members = [];
        foreach($members_tmp as $member){
            if($member->user->id == $request->user()->id){
                $membership = $member->position;
            }
            $members[] = [
                'id' => $member->user->id,
                'name' => $member->user->name,
                'position' => $member->position,
                'avatar' => $member->user->information->avatar,
            ];
        }

        $events_tmp = event_community::where('community_id', $community->id)->get();
        $upevents = [];
        $pastevents = [];
        foreach($events_tmp as $event){
            if($event->event->start > date('Y-m-d H:i:s')){
                $position = user_event::where([['user_id', $request->user()->id],['event_id',$event->event->id]])->first();
                if(!$position){
                    $position = 'pending';
                }
                $upevents[] = [
                    'id' => $event->event->id,   
                    'title' => $event->event->title,   
                    'code' => $event->event->code,   
                    'photo' => $event->event->photo,
                    'start' => $event->event->start,
                    'location' => $event->event->location,
                    'photo' => $event->event->photo,
                    'position' => $position->position,
                ];
            }
            else{
                $position = user_event::where([['user_id', $request->user()->id],['event_id',$event->event->id]])->first();
                if($position->position == 'went' || $position->position == 'organizer'){
                    $position = 'went';
                }
                else if($position->position == 'absent'){
                    $position = "absent";
                }
                $pastevents[] = [
                    'id' => $event->event->id,   
                    'title' => $event->event->title,   
                    'code' => $event->event->code,   
                    'photo' => $event->event->photo,
                    'start' => $event->event->start,
                    'location' => $event->event->location,
                    'photo' => $event->event->photo,
                    'position' => $position,
                ];
            }
        }

        return response(['community' => $communitydetails,'members' => $members, 'upevents' => $upevents, 'pastevents' => $pastevents, 'membership' => $membership], 200);
    }

    public function communityunder(Request $request) {
        $community_tmp = user_community::where('user_id', $request->user()->id)->get();
        $communities = [];
        foreach($community_tmp as $community_id){
            $communities[] = $community_id->community->name;
        }

        return response(['community' => $communities], 200);
    }

    public function joincommunity(Request $request){
        $joinee = user_community::create(['user_id' => $request->user()->id, 'community_id' => $request->id, 'position' => 'member']);
        $joiner = [
            'id' => $joinee->user->id,
            'name' => $joinee->user->name,
            'position' => $joinee->position,
            'avatar' => $joinee->user->information->avatar,
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
        return response(['joiner' => $joiner, 'members' => $members], 200);
    }

    public function uploadprofile(request $request){
        $user = User::findOrFail($request->id);
        if($request['nopic']==false){
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/profiles/']);
            $request['photo'] = Cloudder::getPublicId();
        }
    }
}
