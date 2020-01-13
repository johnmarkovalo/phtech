<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use App\User;
use App\Community;
use App\Event;
use App\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function Dashboard(){

        $communities = Community::all()->count();
        $users = User::all()->count();
        $events = [
            'upcomming' => Event::where('start', '<=' , date("yy/m/d"))->get()->count(),
            'past' => Event::where('start', '>' , date("yy/m/d"))->get()->count()
        ];

        $points = Point::all()->sum('point');

        return response(['communities' => $communities, 'users' => $users, 'events' => $events, 'points' => $points], 200);
    }

    public function BanEvent(Request $request, Event $event){
        $event->update(['status' =>'BANNED']);

        $events = Event::where('status','ACTIVE')->get();

        return response(['events' => $events], 200);
    }

    public function BanUser(Request $request, User $user){
        $user->update(['status' =>'BANNED']);

        $users = User::where('status','ACTIVE')->get();

        return response(['users' => $users], 200);
    }

    public function BanCommunity(Request $request, Community $community){
        $community->update(['status' =>'BANNED']);

        $communities = Community::where('status','ACTIVE')->get();

        return response(['communities' => $communities], 200);
    }

    public function getTopUsers(){
        $users = User::where([['status','ACTIVE']])
                       ->join('points', 'users.id', '=', 'points.user_id')
                       ->limit(10)
                       ->orderBy('points.points', 'desc')
                       ->get();
        foreach($users as $user){
            $TopUsers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'point' => $user->points
            ];
        }
        return response(['users' => $TopUsers], 200);
    }
}
