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
            'code' => 'required|string|max:255',
            'organizer_id' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        // $event = Event::create($request->all());
        $event = Event::create([
            'organizer_id' => $request->organizer_id,
            'title' => $request->title,
            'code' => $request->code,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'location' => $request->location,
            // 'fee' => '',
            // 'limit' => '',

        ]);

        user_event::create(['user_id' => $request->user()->id, 'event_id' => $event->id, 'position' => 'organizer']); 
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
        $event = event_community::create(['event_id' => $request->id, 'community_id' => $community, 'position' => 'organizer']); 
        //for partner
        $partners_tmp = $request->partners;
        foreach($partners_tmp as $partner)
        {
            $community_id = Community::where('name', $partner)->first()->id;
            event_community::create(['event_id' => $request->id, 'community_id' => $community_id, 'position' => 'partner']);
        }
        // return $event;
    }

    public function destroy (Event $event) {
        $event->delete();
    }

    public function index (Request $request) {
        $event_tmp = Event::all();
        $eventlist = [];
        foreach($event_tmp as $event){
            if($event->start > date('Y-m-d H:i:s')){
                $eventlist[] = [
                    'id' => $event->id,
                    'name' => $event->title,
                    'code' => $event->code,
                    'details' => $event->description,
                    'photo' => $event->photo,
                    'location' => $event->location,
                    'start' => $event->start,
                    'end' => $event->end,
                    'color' => 'teal',
                    'community' => event_community::select('community.name')
                            ->join('community', 'event_community.community_id', 'community.id')
                            ->where('event_id', $event->id)->get(),
                    'tags' => event_tech::select('technology.name')
                            ->join('technology', 'event_tech.tech_id', 'technology.id')
                            ->where('event_id', $event->id)->get(),
                ];
            }
        }
        return response(['event' => $eventlist], 200);
    }

    public function eventdetails(Request $request) {
        $event = Event::where('code', $request->code)->first();
        $eventdetails = [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'code' => $event->code,
            'location' => $event->location,
            'photo' => $event->photo,
            'organizer' => [
                'name' => $event->organizer->name,  
                'avatar' => $event->organizer->information->avatar,
            ],
        ];

        $tags = event_tech::select('technology.name')
                        ->join('technology', 'event_tech.tech_id', 'technology.id')
                        ->where('event_id', $event->id)->get();

        $attendees_tmp = user_event::where([['event_id', $event->id],['position', '<>', 'notgoing']])->get();
        $attendees = [];
        foreach($attendees_tmp as $attendee){
            $attendees[] = [
                'id' => $attendee->user->id,
                'name' => $attendee->user->name,
                'position' => $attendee->position,
                'avatar' => $attendee->user->information->avatar,
            ];
        }
        $community_tmp = event_community::where('event_id', $event->id)->get();
        $communities = [];
        foreach($community_tmp as $community){
            $communities[] = [
                'id' => $community->community->id,
                'name' => $community->community->name,
                'position' => $community->position,
                'photo' => $community->community->photo,
            ];
        }
        return response(['event' => $eventdetails,'attendees' => $attendees, 'communities' => $communities, 'tags' => $tags], 200);
    }

    public function joinevent(Request $request){
        $attendee = user_event::create(['user_id' => $request->user()->id, 'event_id' => $request->id, 'position' => 'going']);

        return response(['attendee' => $attendee], 200);
    }

    public function uploadprofile(request $request){
        $user = User::findOrFail($request->id);
        if($request['nopic']==false){
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/profiles/']);
            $request['photo'] = Cloudder::getPublicId();
        }
    }
}
