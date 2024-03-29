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

class UserController extends Controller
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
        $users = User::where([['user_type', 'user'],['status','ACTIVE']])->get();
        return response(['users' => $users], 200);
        // return 'fuck';
    }

    public function user_notification(Request $request) {
        $notifications = $request->user()->notifications;
        return response(['success' => ['notifications' => $notifications]]);
    }

    public function read_user_notification(Request $request) {
        $request->user()->unreadNotifications->markAsRead();
        $notifications = $request->user()->notifications;

        return response(['success' => ['notifications' => $notifications]]);
        
    }

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

}
