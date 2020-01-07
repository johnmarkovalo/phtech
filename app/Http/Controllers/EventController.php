<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\User;
use App\Technology;
use App\Community;
use App\Event;
use App\event_community;
use App\info_tech;
use App\event_tech;
use App\user_community;
use App\user_event;
use App\Point;
use App\point_logs;
use App\EventSponsor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEvent;
use App\Notifications\CallForSpeaker;

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
            'fee' => $request->fee,
            'limit' => $request->limit,
            'exclusive' => $request->exclusive

        ]);

        user_event::create(['user_id' => $request->user()->id, 'event_id' => $event->id, 'position' => 'organizer']); 
        return response(['event' => $event], 200);
        // return $community_tmp;

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

    public function eventsponsor ($request) {
        EventSponsor::where('event_id', $request->id)->delete();
        $sponsors_tmp = $request->sponsors;
        foreach($sponsors_tmp as $sponsor)
        {
            EventSponsor::create(['event_id' => $request->id, 'sponsor_name' => $sponsor]);
        }
    }

    public function eventcommunity (Request $request) {
        event_community::where('event_id', $request->id)->delete();
        //for organizer
        $community = Community::where('name', $request->community)->first();
        $event = event_community::create(['event_id' => $request->id, 'community_id' => $community->id, 'position' => 'organizer']); 
        //for partner
        $partners_tmp = $request->partners;
        foreach($partners_tmp as $partner)
        {
            $community_id = Community::where('name', $partner)->first()->id;
            event_community::create(['event_id' => $request->id, 'community_id' => $community_id, 'position' => 'partner']);
        }

        $message = [
            'event_id' => $request->id,
            'community_photo' => $community->photo,
            'message' => 'Checkout ' . $community->name . ' Newest Event',
        ];

        $members_tmp = user_community::where([['community_id', $community->id], ['position', '<>' ,'removed']])->get();
        $members = [];
        foreach($members_tmp as $member){
            $members[] = $member->user;
        }

        Notification::send($members, new NewEvent($message));

        //Call for Speaker Notif
        $speakers = [];
        foreach($request->speakers as $speaker){
            $speakers [] = User::where('id',$speaker)->get();
        }
        $message = [
            'event_id' => $request->id,
            'community_photo' => $community->photo,
            'message' => $community->name . ' Requested you to be Speaker in their newest event',
        ];
        Notification::send($speakers, new CallForSpeaker($message));

        $this->eventsponsor($request);
    }

    public function destroy (Event $event) {
        $event->delete();
    }

    public function index (Request $request) {
        $event_tmp = Event::all();
        $eventlist = [];
        foreach($event_tmp as $event){
            if($event->start > date('Y-m-d H:i:s')){
                $position = user_event::where([['user_id', $request->id],['event_id',$event->id]])->first();
                $community_tmp = event_community::where([['event_id', $event->id],['position', 'organizer']])->first();
                if(!$position){
                    $position = 'pending';
                }
                else{
                    $position = $position->position;
                }
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
                    'community_organizer' => $community_tmp->community->name,
                    'community' => $this->getCommunities($event->id),
                    'tags' => $this->getTags($event->id),
                    'position' =>  $position,
                ];
            }
        }

        // $tags = info_tech::select('technology.id')
        //                    ->join('technology', 'info_tech.tech_id', 'technology.id')
        //                    ->where('info_id', $request->user()->information->id)->get();

        // $recommended = Event::join('event_tech', 'event_tech.event_id', 'event.id')->
        //                     join('technology', 'event_tech.tech_id', 'technology.id')->
        //                     whereHas('genres.users', function($q) use ($userId){
        //                         $q->where('users.id', $userId);
        //                     })->whereHas('years.users', function($q) use ($userId){
        //                         $q->where('users.id', $userId);
        //                     })->whereHas('runtimes.users', function($q) use ($userId){
        //                         $q->where('users.id', $userId);
        //                     })->get();
   

        // $recommended = Event::join('technology', 'info_tech.tech_id', 'technology.id')->
        //                 whereHas('genres.users', function($q) use ($userId){
        //                     $q->where('users.id', $userId);
        //                 })->whereHas('years.users', function($q) use ($userId){
        //                     $q->where('users.id', $userId);
        //                 })->whereHas('runtimes.users', function($q) use ($userId){
        //                     $q->where('users.id', $userId);
        //                 })->get();

        return response(['event' => $eventlist], 200);
    }
    
    public function eventdetails(Request $request) {
        $event = Event::where('code', $request->code)->first();
        $status = $this->getStatus($request->user()->id,$event);
        // return $status;
        $eventdetails = [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'code' => $event->code,
            'location' => $event->location,
            'photo' => $event->photo,
            'start' => $event->start,
            'limit' => $event->limit,
            'fee' => $event->fee,
            'exclusive' => $event->exclusive,
            'organizer' => [
                'name' => $event->organizer->name,  
                'avatar' => $event->organizer->information->avatar,
            ],
            'settings' => $status['settings'],
            'upcomming' => $status['upcomming'],
        ];
        $tags = $this->getTags($event->id);

        $attendees = $this->getAttendees($event->id);

        $communities = $this->getCommunities($event->id);

        return response(['event' => $eventdetails,'attendees' => $attendees, 'communities' => $communities, 'tags' => $tags, 'status' => $status['status']], 200);
    }

    public function joinevent(Request $request){
        user_event::where([['user_id',$request->attendee_id], ['event_id',$request->id]])->delete();
        if($request->upcomming){
            if($request->status == true){
                $attendee = user_event::create(['user_id' => $request->attendee_id, 'event_id' => $request->id, 'position' => 'going']);
            }
            elseif($request->status == false){
                $attendee = user_event::create(['user_id' => $request->attendee_id, 'event_id' => $request->id, 'position' => 'notgoing']);
            }
        }
        else{
            if($request->status == true){
                $attendee = user_event::create(['user_id' => $request->attendee_id, 'event_id' => $request->id, 'position' => 'went']);
                point_logs::create(['point_id' => $attendee->user->point->id, 'event_id' => $request->id, 'position' => 'attendee', 'point' => '5']);
                Point::where('id', $attendee->user->point->id)->increment('points', 5);
            }
            elseif($request->status == false){
                $attendee = user_event::create(['user_id' => $request->attendee_id, 'event_id' => $request->id, 'position' => 'absent']);
                point_logs::where([['point_id',$attendee->user->point->id], ['event_id',$request->id]])->delete();
                Point::where('id', $attendee->user->point->id)->decrement('points', 5);
            }
        }

        $attendees_tmp = user_event::where([['event_id', $request->id]])->get();
        $attendees = [];
        foreach($attendees_tmp as $attende){
            $attendees[] = [
                'id' => $attende->user->id,
                'name' => $attende->user->name,
                'position' => $attende->position,
                'avatar' => $attende->user->information->avatar,
            ];
        }

        return response(['attendee' => $attendee, 'attendees' => $attendees], 200);
        // return ($request->status);
    }

    public function getTags($id){
        $tags = event_tech::select('technology.name')
                        ->join('technology', 'event_tech.tech_id', 'technology.id')
                        ->where('event_id', $id)->get();

        return $tags;
    }

    public function getAttendees($id){
        $attendees_tmp = user_event::where([['event_id', $id]])->get();
        $attendees = [];
        foreach($attendees_tmp as $attende){
            $attendees[] = [
                'id' => $attende->user->id,
                'name' => $attende->user->name,
                'position' => $attende->position,
                'avatar' => $attende->user->information->avatar,
            ];
        }

        return $attendees;
    }

    public function getCommunities($id){
        $community_tmp = event_community::where('event_id', $id)->get();
        $communities = [];
        foreach($community_tmp as $community){
            $communities[] = [
                'id' => $community->community->id,
                'name' => $community->community->name,
                'position' => $community->position,
                'photo' => $community->community->photo,
            ];
        }
        return $communities;
    }
    
    public function getStatus($user_id,$event){
        $community = event_community::where('event_id', $event->id)->first();
        $position_tmp = user_community::where([['user_id', $user_id],['community_id', $community->community->id]])->first();
        $position = $position_tmp->position;
        if($event->organizer->id == $user_id || $position == 'organizer' || $position == 'event-organizer'){
            $settings = true;
        }
        else{
            $settings = false;
        }
        $status = user_event::where([['event_id',$event->id],['user_id',$user_id]])->first();
        if($status){
            $status = $status->position;
        }
        else{
            $status = 'pending';
        }
        if($event->start > date('Y-m-d H:i:s')){
            $upcomming = true;
        }
        else{
            $upcomming = false;
        }
        $status = [
            'status' => $status,
            'settings' => $settings,
            'upcomming' => $upcomming
        ];
        return $status;
    }

    public function upload_profile (Request $request , Event $event){
        try {
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/community/']);

            $event->update(['photo' => Cloudder::getResult()['secure_url']]);

            return response(['success' => ['photo' => Cloudder::getResult()['secure_url']]]);

        } catch (\Throwable $th) {
            return ['error'=>true, 'message'=>$th];
        }
    }

    public function upload_payment (Request $request , Event $event){
        try {
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/payment/']);

            $photo = Cloudder::getResult()['secure_url'];



            return response(['success' => ['photo' => Cloudder::getResult()['secure_url']]]);

        } catch (\Throwable $th) {
            return ['error'=>true, 'message'=>$th];
        }
    }
}
