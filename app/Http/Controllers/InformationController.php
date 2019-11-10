<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Technology;
use App\Community;
use App\Event;
use App\Information;
use App\info_tech;
use App\user_event;
use App\user_community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{

    public function update (Request $request) {
        $validator = Validator::make($request->all(), [ 
            // 'name' => 'required|string|max:255',
            // 'description' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $information = Information::where('user_id', $request->user_id)->first()->update($request->toArray());

        return response(['information' => $information], 200);
    }

    public function infotech (Request $request) {
        $info_id = Information::where('user_id', $request->user_id)->first()->id;
        info_tech::where('info_id', $info_id)->delete();
        $tags_tmp = $request->tags;
        foreach($tags_tmp as $tag)
        {
            $tech_id = Technology::where('name', $tag)->first()->id;
            info_tech::create(['info_id' => $info_id, 'tech_id' => $tech_id]);
        }
    }

    public function destroy (Technology $technology) {
        $technology->delete();
    }

    public function index (Request $request) {
        // $information = Information::where('user_id', $request->user_id);
        $info = [
            'firstname' => $request->user()->information->firstname,
            'lastname' => $request->user()->information->lastname,
            'name' => $request->user()->name,
            'avatar' => $request->user()->information->avatar,
            'affiliate' => $request->user()->information->affiliation,
            'position' => $request->user()->information->position,
            'occupation' => $request->user()->information->occupation,
            'bio' => $request->user()->information->bio,
            'address' => $request->user()->information->address,
            'email' => $request->user()->email,
            'points' => $request->user()->point->points,
        ];

        $events_tmp = user_event::where('user_id', $request->user()->id)->get();
        $events = [];
        foreach($events_tmp as $event_tmp){
            $event = Event::where('id', $event_tmp->event_id)->first();
            $events [] = [
                'id' => $event->id,
                'title' => $event->title,
                'photo' => $event->photo,
                'start' => $event->start,
            ];
        }

        $community_tmp = user_community::where('user_id', $request->user()->id)->get();
        $communities = [];
        foreach($community_tmp as $community_tmp){
            $community = Community::where('id', $community_tmp->community_id)->first();
            $position = user_community::where('user_id', $request->user()->id)->first()->position;
            $communities [] = [
                'id' => $community->id,
                'name' => $community->name,
                'photo' => $community->photo,
                'position' => $position,
            ];
        }

        $tags = info_tech::select('technology.name')
                           ->join('technology', 'info_tech.tech_id', 'technology.id')
                           ->where('info_id', $request->user()->information->id)->get();
                           
        return response(['information' => $info, 'tags' =>  $tags ,'events' => $events ,'communities' => $communities], 200);
    }

    public function uploadprofile(request $request){
        $user = User::findOrFail($request->id);
        if($request['nopic']==false){
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/profiles/']);
            $request['photo'] = Cloudder::getPublicId();
        }
    }
}
