<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Notifications\NewEvent;
use App\Notifications\CallForSpeaker;
use App\Notifications\CallForSpeakerReply;
use App\Notifications\NewAttendee;
use App\Notifications\ProofOfPayment;
use App\Notifications\ProofOfPaymentReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;


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
    
    public function update (Request $request, Event $event) {
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required',
            'end' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $event->update($request->toArray());

        return response(['event' => $event], 200);
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
        if($sponsors_tmp){
            foreach($sponsors_tmp as $sponsor_tmp){
                // echo $sponsor();
                $sponsor = $sponsor_tmp['name'];
                EventSponsor::create(['event_id' => $request->id, 'name' => $sponsor]);
            }
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
        //Notif of New Event
        if($request->status == 'New'){
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
                $speakers[] = User::where('id',$speaker)->first();
            }
            $message = [
                'event_id' => $request->id,
                'community_photo' => $community->photo,
                'status' => 'pending',
                'message' => $community->name . ' Requested you to be Speaker in their newest event',
            ];
            // return $speakers;
            Notification::send($speakers, new CallForSpeaker($message));
        }else{
            foreach($request->removedSpeakers as $speaker){
                $user_event = user_event::where([['user_id',$speaker], ['event_id',$request->id]])->first();
                $user_event->update(['position' => 'going']);
            }
            //Call for Speaker Notif
            $speakers = [];
            foreach($request->speakers as $speaker){
                $speakers[] = User::where('id',$speaker)->first();
            }
            $message = [
                'event_id' => $request->id,
                'community_photo' => $community->photo,
                'status' => 'pending',
                'message' => $community->name . ' Requested you to be Speaker in their newest event',
            ];
            // return $speakers;
            Notification::send($speakers, new CallForSpeaker($message));
        }
        

        $this->eventsponsor($request);
    }

    public function destroy (Event $event) {
        $event->delete();
    }

    public function index (Request $request) {
        $allevents = Event::all();
        $eventlist = [];
        $community_tmp = '';
        $recommended_events = [];
        if($request->id){
            foreach($allevents as $event){
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

            $recommended = [];
            $user = User::where('id',$request->id)->first();
            $user_tags = $user->information->technologies;
            foreach($user_tags as $tag){
                $recommended[] = Event::whereHas('technologies', function($q) use ($tag){
                    $q->where('technology.id', $tag->id);
                })->get();
                // $recommended[] = $tag->id;
            }

            $events = [];
            foreach($recommended as $tag){
                foreach($tag as $eventwaiting){
                    $count = 0; 
                    if($events != null){
                        foreach($events as $eventinlist){
                            if($eventinlist['event']['id'] == $eventwaiting['id']){
                                $eventinlist['count'] = $eventinlist['count'] + 1; 
                                $count++; 
                                // return $eventinlist;
                            }
                        }
                        if($count == 0){
                            $events[] = [
                                'event' => $eventwaiting,
                                'count' => 0
                            ];
                        }
                    }
                    else{
                        $events[] = [
                            'event' => $eventwaiting,
                            'count' => 0
                        ];
                    }
                    // return $eventwaiting['id'];
                }
            }

            $recommended_events_tmp = [];
            foreach($events as $event){
                $recommended_events_tmp[] = $event['event'];
            }

            $community_tmp = '';
            foreach($recommended_events_tmp as $event){
                if($event->start > date('Y-m-d H:i:s')){
                    $position = user_event::where([['user_id', $request->id],['event_id',$event->id]])->first();
                    $community_tmp = event_community::where([['event_id', $event->id],['position', 'organizer']])->first();
                    if(!$position){
                        $position = 'pending';
                    }
                    else{
                        $position = $position->position;
                    }
                    $recommended_events[] = [
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

        }else{
            foreach($allevents as $event){
                if($event->start > date('Y-m-d H:i:s')){
                    $community_tmp = event_community::where([['event_id', $event->id],['position', 'organizer']])->first();
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
                        'position' =>  'pending',
                    ];
                }
            }
        }
        return response(['events' => $eventlist, 'recommended_events' => $recommended_events], 200);
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
            'end' => $event->end,
            'limit' => $event->limit,
            'fee' => $event->fee,
            'exclusive' => $event->exclusive,
            'allowed' => $status['allowed'],
            'organizer' => [
                'name' => $event->organizer->name,  
                'avatar' => $event->organizer->information->avatar,
            ],
            'settings' => $status['settings'],
            'upcomming' => $status['upcomming'],
            'qrcode' => $status['qrcode'],
            'ratings' => $status['ratings'],
            'submitted' => $status['submitted'],
            'attendeescount' => $status['attendeescount'],
        ];
        $tags = $this->getTags($event->id);

        $attendees = $this->getAttendees($event->id);
        $speakers = [];
        foreach($attendees as $attendee){
            if($attendee['position'] == 'speaker'){
                $speakers[] = $attendee;
            }
        }
        // $speakers = $this->getSpeakers($attendees);
        $sponsors_tmp = EventSponsor::select('name')->where([['event_id', $event->id]])->get();
        $sponsors = [];
        foreach($sponsors_tmp as $sponsor){
            $sponsors[] = [
                'name' => $sponsor->name
            ];
        }
        // $sponsors = $this->getSponsors($event->id);

        $communities = $this->getCommunities($event->id);

        return response(['event' => $eventdetails,'attendees' => $attendees, 'speakers' => $speakers, 'sponsors' => $sponsors, 'communities' => $communities, 'tags' => $tags, 'status' => $status['status']], 200);
    }

    public function joinevent(Request $request){
        user_event::where([['user_id',$request->attendee_id], ['event_id',$request->id]])->delete();
        if($request->upcomming){
            if($request->status == true){
                $attendee = user_event::create(['user_id' => $request->attendee_id, 'event_id' => $request->id, 'position' => 'going', 'qrcode' => $request->qrcode]);

                $organizer_tmp = user_event::where(['position' => 'organizer', 'event_id' => $request->id])->first();
                $organizer = $organizer_tmp->user;
                $event = $organizer_tmp->event;
                $message = [
                    'user_id' => $attendee->user->id,
                    'user_photo' => $attendee->user->information->avatar,
                    'message' => $attendee->user->name . ' Joined ' . $event->title,
                ];

                Notification::send($organizer, new NewAttendee($message));
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

    public function checkAttendance(Request $request){
        $event = Event::where('code',$request->code)->first();
        $code = $request->qrcode;   
        $user_event = user_event::where([['qrcode',$code],['event_id',$event->id]])->first();
        $user = $user_event->user;
        if($user_event){
            $user_event->update(['position' => 'went']);
            // point_logs::create(['point_id' => $user->point->id, 'event_id' => $event->id, 'position' => 'attendee', 'point' => '5']);
            // Point::where('id', $user->point->id)->increment('points', 5);
            return response(['success' => ['user' => $user]]);
        }
        else{
            return response(['errors' => ['QR Code Not Found']], 422);
        }
    }

    public function GiveRewardPoints($event){
        
        $attendeereviewpercentage = ($reviews_count / $attendees_count);
        $attendees_tmp = user_event::where([['event_id', $event->id],['position', 'went']])->get();
        $speakers_tmp = user_event::where([['even_idt', $event->id],['position', 'speaker']])->get();
        $organizers_tmp = user_event::where([['event_id', $event->id],['position', 'organizer']])->get();

        $reviews_count = user_event::where([['event_id', $event->id],['rate', null]])->get()->count();
        $attendees_count = count($attendees_tmp);
        
        $attendees = [];
        foreach($attendees_tmp as $attendee){
            $attendees[] = $attendee->user;
        }

        $speakers = [];
        foreach($speakers_tmp as $speaker){
            $speakers[] = $speaker->user;
        }

        $organizers = [];
        foreach($organizers_tmp as $organizer){
            $organizers[] = $organizer->user;
        }

        $pointsforattendees = 0;
        if($attendees_count <= 50){
            $pointsforattendees = 5;
        }elseif($attendees_count <= 100 && $attendees_count > 50){
            $pointsforattendees = 10;
        }elseif($attendees_count <= 200 && $attendees_count > 100){
            $pointsforattendees = 15;
        }elseif($attendees_count <= 400 && $attendees_count > 200){
            $pointsforattendees = 20;
        }elseif($attendees_count <= 600 && $attendees_count > 400){
            $pointsforattendees = 25;
        }elseif($attendees_count > 600){
            $pointsforattendees = 30;
        }

        $pointsforspeakers = ($pointsforattendees * 0.20) + $pointsforattendees;
        $pointsfororganizer = ($pointsforattendees * 0.20) + ($pointsforattendees * 0.20+$pointsforattendees)($attendeereviewpercentage);

        foreach($attendees as $attendee){
            point_logs::create(['point_id' => $attendee->point->id, 'event_id' => $event->id, 'position' => 'attendee', 'point' => $pointsforattendees]);
            Point::where('id', $attendee->point->id)->increment('points', $pointsforattendees);
        }
        foreach($speakers as $speaker){
            point_logs::create(['point_id' => $speaker->point->id, 'event_id' => $event->id, 'position' => 'attendee', 'point' => $pointsforspeakers]);
            Point::where('id', $speaker->point->id)->increment('points', $pointsforspeakers);
        }
        foreach($organizers as $organizer){
            point_logs::create(['point_id' => $organizer->point->id, 'event_id' => $event->id, 'position' => 'attendee', 'point' => $pointsfororganizer]);
            Point::where('id', $organizer->point->id)->increment('points', $pointsfororganizer);
        }
    }
    //Pending
    public function replyrequest(Request $request){
        $notification = $request->notification;
        $status = '';
        if($request->status){
            $notification['data']['status'] = 'accepted';
            $status = 'accepted';
        }
        else{
            $notification['data']['status'] = 'declined';
            $status = 'declined';

        }
        DB::table('notifications')->where('id', $request->notification['id'])->update(['data' => $notification['data']]);

        if($notification['type'] == 'App\Notifications\CallForSpeaker'){
            $event = Event::where('id', $notification['data']['event_id'])->first();
            user_event::where([['user_id',$request->user()->id], ['event_id',$event->id]])->delete();
            user_event::create(['user_id' => $request->user()->id, 'event_id' => $event->id, 'position' => 'speaker', 'qrcode' => $request->code]);
            $organizer = $event->organizer;

            if($status == 'accepted'){
                $message = [
                    'event_id' => $event->id,
                    'user_photo' => $request->user()->information->avatar,
                    'status' => 'approved',
                    'message' => $request->user()->name . ' Accepted to become a speaker in ' . $event->title,
                ];
            }
            else{
                $message = [
                    'event_id' => $event->id,
                    'user_photo' => $request->user()->information->avatar,
                    'status' => 'disapproved',
                    'message' => $request->user()->name . ' Declined to become a speaker in ' . $event->title,
                ];
            }
            Notification::send($organizer, new CallForSpeakerReply ($message));
        }
        elseif($notification['type'] == 'App\Notifications\ProofOfPayment'){
            $event = Event::where('id', $notification['data']['event_id'])->first();
            $community_tmp = event_community::where('event_id',$event->id)->first();
            $user = User::where('id', $notification['data']['user_id'])->first();
            user_event::where([['user_id',$user->id], ['event_id',$event->id]])->delete();
            user_event::create(['user_id' => $user->id, 'event_id' => $event->id, 'position' => 'going', 'qrcode' => $request->code]);
            if($status == 'accepted'){
                $message = [
                    'event_id' => $event->id,
                    'community_photo' => $community_tmp->community->photo,
                    'status' => 'approved',
                    'message' => $request->user()->name . ' The Organizer approved your proof of payment for ' . $event->title,
                ];
            }
            else{
                $message = [
                    'event_id' => $event->id,
                    'community_photo' => $community_tmp->community->photo,
                    'status' => 'disapproved',
                    'message' => $request->user()->name . ' The Organizer disapproved your proof of payment for ' . $event->title,
                ];
            }
            Notification::send($user, new ProofOfPaymentReply ($message));

        }

        $notifications = $request->user()->notifications;
        return response(['success' => ['notifications' => $notifications]]);
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
                'points' => $attende->user->point->points
            ];
        }

        return $attendees;
    }

    public function getSpeakers($attendees){
        $speakers = [];
        foreach($attendees as $attendee){
            if($attendee['position'] == 'speaker'){
                $speakers[] = [
                    'id' => $attende->user->id,
                    'name' => $attende->user->name,
                    'position' => $attende->position,
                    'avatar' => $attende->user->information->avatar,
                    'points' => $attende->user->point->points
                ];
            }
        }

        return $speakers;
    }

    public function getSponsors($id){
        $sponsors_tmp[] = EventSponsor::where([['event_id', $id]])->get();
        $sponsors = [];
        // foreach($sponsors_tmp as $sponsor){
        //     $sponsors[] = $sponsor->sponsor_name;
        // }
        return $sponsors_tmp;
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
        $allowedToJoin = false;
        $communities = event_community::where('event_id', $event->id)->get();
        foreach($communities as $community){
            $position_tmp = user_community::where([['user_id', $user_id],['community_id', $community->community->id]])->first();
            if($position_tmp){
                $position = $position_tmp->position;
                $allowedToJoin = true;
                break;
            }
            else{
                $position = '';
            }
        }
        if($event->organizer->id == $user_id || $position == 'organizer' || $position == 'event-organizer'){
            $settings = true;
        }
        else{
            $settings = false;
        }
        $qrcode = '';
        $submitted = false;
        $ratings = '';
        $status = user_event::where([['event_id',$event->id],['user_id',$user_id]])->first();
        // echo($status);
        if($status){
            $qrcode = $status->qrcode;
            $status = $status->position;
            $ratings_tmp = user_event::select('ratings')->where([['event_id',$event->id],['user_id',$user_id]])->first();
            $ratings = $ratings_tmp->ratings;
            if($ratings){
                $submitted = true;
            }
            // echo($ratings);
        }
        else{
            $status = 'pending';
            $ratings = null;
        }
        if($event->start > date('Y-m-d H:i:s')){
            $upcomming = true;
        }
        else{
            $upcomming = false;
            if(!$ratings && $submitted == false){
               $ratings = user_event::where('event_id',$event->id)->avg('ratings');
            }
        }
        $attendeescount = null;
        if($event->limit != 0){
            $attendeescount = [
                'count' => user_event::where([['event_id', $event->id],['position','<>','notgoing']])->get()->count(),
                'over' => $event->limit
            ];
        }

        $status = [
            'status' => $status,
            'settings' => $settings,
            'upcomming' => $upcomming,
            'allowed' => $allowedToJoin,
            'qrcode' => $qrcode,
            'ratings' => $ratings,
            'submitted' => $submitted,
            'attendeescount' => $attendeescount,
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
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/payment/']);

            $photo = Cloudder::getResult()['secure_url'];

            $organizers = $event->organizer;
            $message = [
                'event_id' => $event->id,
                'user_id' => $request->user()->id,
                'user_photo' => $request->user()->information->avatar,
                'proof' => $photo,
                'status' => 'pending',
                'message' => $request->user()->name . ' Sent a proof of payment for the event ' . $event->title,
            ];
            

            Notification::send($organizers, new ProofOfPayment($message));

            return response(['success' => ['photo' => $photo]]);    
    }
}
