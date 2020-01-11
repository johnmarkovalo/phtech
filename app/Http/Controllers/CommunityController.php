<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Hash;
use App\Technology;
use App\User;
use App\Community;
use App\community_tech;
use App\event_tech;
use App\user_community;
use App\user_event;
use App\event_community;
use App\EventSponsor;
use App\Notifications\NewMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class CommunityController extends Controller{
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'organizer_id' => 'required|string|max:255',
            'description' => 'required|string',
            // 'location' => 'required',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $community = Community::create($request->all());
        user_community::create(['user_id' => $request->organizer_id, 'community_id' => $community->id, 'position' => 'organizer']);
        return response(['community' => $community], 200);

    }
    
    public function update (Request $request, Community $community) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $community->update($request->toArray());

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
                'tags' => $this->getTags($community->id),
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
            'description' => $community->description,
            'organizer' => $community->organizer->name,
            'tags' => $this->getTags($community->id),
        ];

        if(user_community::where([['user_id', $request->user()->id],['community_id',$community->id]])->exists()){
            $membership = user_community::where([['user_id', $request->user()->id],['community_id',$community->id]])->first()->position;
        }
        else{
            $membership = null;
        }

        $members = $this->getMembers($community->id);

        
        $events_tmp = event_community::where('community_id', $community->id)->orderBy('id', 'desc')->get();
        
        $events = $this->getEvents($events_tmp,$request->user()->id);
        
        $upevents = $events['upevents'];

        $pastevents = $events['pastevents'];

        return response(['community' => $communitydetails,'members' => $members, 'upevents' => $upevents, 'pastevents' => $pastevents, 'membership' => $membership], 200);
    }

    public function communityunder(Request $request) {
        $community_tmp = Community::where('name', '<>' , $request->community)->get();
        $communities = [];
        foreach($community_tmp as $community){
            $communities[] = $community->name;
        }

        return response(['community' => $communities], 200);
    }

    public function communitysponsor(Request $request) {
        $community = Community::where('name', $request->community)->get();
        $sponsors = [];
        $sponsors_tmp = [];
        if($community){
            $sponsors_tmp = EventSponsor::select('event_sponsors.name')
                    ->join('event', 'event_sponsors.event_id', 'event.id')
                    ->join('event_community', 'event_community.event_id', 'event.id')
                    ->groupBy('event_sponsors.name')
                    ->where('event_community.community_id', $community['0']['id'])->get();

            foreach($sponsors_tmp as $sponsor){
                $sponsors[] = $sponsor;
            }
        }

        // $community_tmp = Community::where('name', '<>' , $request->community)->first();
        // $events_tmp = event_community::where('community_id',$community_tmp->id)->get();
        // $events = [];
        // foreach($events_tmp as $event){
        //     $events[] = Event::where('id',$event->event_id)->get();
        // }
        // $sponsors = [];
        // foreach($community_tmp as $community){
        //     $communities[] = $community->name;
        // }

        return response(['sponsors' => $sponsors], 200);
    }

    public function joincommunity(Request $request){
        user_community::where(['user_id' => $request->user()->id, 'community_id' => $request->id])->delete();
        $joinee = user_community::create(['user_id' => $request->user()->id, 'community_id' => $request->id, 'position' => 'member']);
        $joiner = [
            'id' => $joinee->user->id,
            'name' => $joinee->user->name,
            'position' => $joinee->position,
            'avatar' => $joinee->user->information->avatar,
        ];

        $organizers_tmp = user_community::where(['position' => 'organizer', 'community_id' => $request->id])->get();
        $organizers = [];
        $community = '';
        foreach($organizers_tmp as $organizer){
            $organizers[] = $organizer->user;
            $community = $organizer->community;
        }
        // return $organizers;

        $message = [
            'user_id' => $joiner['id'],
            'user_photo' => $joiner['avatar'],
            'message' => $joiner['name'] . ' Joined ' . $community->name,
        ];

        Notification::send($organizers, new NewMember($message));

        $members = $this->getMembers($request->id);

        return response(['joiner' => $joiner, 'members' => $members], 200);
    }

    public function changeRole(Request $request, Community $community){
        user_community::where([['user_id',$request->member], ['community_id',$community->id]])->delete();
        user_community::create(['user_id' => $request->member, 'community_id' => $community->id, 'position' => $request->role]);
        $members = $this->getMembers($community->id);

        return response(['members' => $members], 200);
    }

    public function removeMember(Request $request, Community $community){
        if($request->member == 'leave'){
            $request->member = $request->user()->id;
        }
        user_community::where([['user_id',$request->member], ['community_id',$community->id]])->delete();
        user_community::create(['user_id' => $request->member, 'community_id' => $community->id, 'position' => 'removed']);
        $members = $this->getMembers($community->id);

        return response(['members' => $members], 200);
    }

    public function getEvents($events, $id){
        $upevents = [];
        $pastevents = [];
        $newevents = [];
        $position = '';
        foreach($events as $event){
            $community = event_community::select('community.name')
                ->join('community', 'event_community.community_id', 'community.id')
                ->where('event_id', $event->id)->get();
            if($event->event->start > date('Y-m-d H:i:s')){
                $position = user_event::where([['user_id', $id],['event_id',$event->event->id]])->first();
                if(!$position){
                    $position = 'pending';
                }
                else{
                    $position = $position->position;
                }
                $upevents[] = [
                    'id' => $event->event->id,   
                    'title' => $event->event->title,   
                    'code' => $event->event->code,   
                    'photo' => $event->event->photo,
                    'start' => $event->event->start,
                    'location' => $event->event->location,
                    'photo' => $event->event->photo,
                    'position' => $position,
                    'tags' => $this->getEventTags($event->id),
                    'community_name' => $community,
                ];
            }
            else{
                $position = user_event::where([['user_id', $id],['event_id',$event->event->id]])->first();
                if(!$position){
                    $position = '';
                }
                else if($position->position == 'went' || $position->position == 'organizer'){
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
                    'tags' => $this->getEventTags($event->id),
                    'community_name' => $community,
                ];
            }
            $newevents[] = [
                'id' => $event->event->id,   
                'title' => $event->event->title,   
                'code' => $event->event->code,   
                'photo' => $event->event->photo,
                'start' => $event->event->start,
                'location' => $event->event->location,
                'photo' => $event->event->photo,
                'position' => $position,
                'tags' => $this->getEventTags($event->id),
                'community_name' => $community,
            ];
        }

        // $newevents = array_merge($upevents, $pastevents);

        $events = [
            'events' => $newevents,
            'pastevents' => $pastevents,
            'upevents' => $upevents,
        ];

        return $events;
    }

    public function getMembers($id){
        $members_tmp = user_community::where([['community_id', $id], ['position', '<>' ,'removed']])->get();
        $members = [];
        foreach($members_tmp as $member){
            $members[] = [
                'id' => $member->user->id,
                'name' => $member->user->name,
                'position' => $member->position,
                'avatar' => $member->user->information->avatar,
                'points' => $member->user->point->points
            ];
        }

        return $members;
    }

    public function getTags($id){
        $tags_tmp = community_tech::select('technology.name')
                ->join('technology', 'community_tech.tech_id', 'technology.id')
                ->where('community_id', $id)->get();

        $tags = [];
        foreach($tags_tmp as $tag){
            $tags[] = $tag->name;
        }
        return $tags;
    }

    public function getEventTags($id){
        $tags = event_tech::select('technology.name')
                ->join('technology', 'event_tech.tech_id', 'technology.id')
                ->where('event_id', $id)->get();

        return $tags;
    }

    public function upload_profile (Request $request , Community $community){
        try {
            Cloudder::upload($request['photo'], null, ['folder'=>'phtechpark/community/']);

            $community->update(['photo' => Cloudder::getResult()['secure_url']]);

            return response(['success' => ['photo' => Cloudder::getResult()['secure_url']]]);

        } catch (\Throwable $th) {
            return ['error'=>true, 'message'=>$th];
        }
    }
}
