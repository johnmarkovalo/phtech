<?php

use Illuminate\Http\Request;

    Route::post('/login', 'AuthController@login')->name('login.api');
    Route::post('/register', 'AuthController@register')->name('register.api');
    Route::get('/technology', 'TechnologyController@index');
    Route::get('/community', 'CommunityController@index');
    Route::get('/event', 'EventController@index');
    // private routes
    Route::middleware('auth:api')->group(function () {
        // Get current logged in user
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/notifications', 'UserController@user_notification');
        Route::post('/notifications/read', 'UserController@read_user_notification');

        //Admin
        Route::get('/dashboard', 'AdminController@Dashboard');
        Route::get('/top-users', 'AdminController@getTopUsers');
        Route::put('/ban-event/{event}', 'AdminController@BanEvent');
        Route::put('/ban-user/{user}', 'AdminController@BanUser');
        Route::put('/ban-community/{community}', 'AdminController@BanCommunity');

        //Get all users
        Route::get('/users', 'UserController@index');

        // Logout
        Route::post('/logout', 'AuthController@logout')->name('logout');
        
        // Technology
        Route::post('/technology', 'TechnologyController@store');
        Route::put('/technology/{technology}', 'TechnologyController@update');
        Route::put('/newtechnology', 'TechnologyController@saveNew');
        Route::delete('/technology/{technology}', 'TechnologyController@destroy');
        
        // Information
        Route::get('/information', 'InformationController@index');
        // Route::get('/information/{information}', 'InformationController@show');
        Route::put('/information/upload-profile', 'InformationController@upload_profile');
        Route::put('/information/{information}', 'InformationController@update');
        Route::delete('/information/{information}', 'InformationController@destroy');

        //Information Technology
        Route::put('/infotech/{information}', 'InformationController@infotech');

        // Community
        Route::post('/community', 'CommunityController@store');
        Route::put('/community/{community}', 'CommunityController@update');
        Route::delete('/community/{community}', 'CommunityController@destroy');
        Route::get('/community/{community}', 'CommunityController@communitydetails');
        Route::get('/community-under', 'CommunityController@communityunder');
        Route::get('/community-sponsor', 'CommunityController@communitysponsor');
        Route::put('/joincommunity', 'CommunityController@joincommunity');
        Route::put('/community/change-role/{community}', 'CommunityController@changeRole');
        Route::put('/community/remove-member/{community}', 'CommunityController@removeMember');
        Route::put('/community/upload-profile/{community}', 'CommunityController@upload_profile');


        // Route::get('/community/members', 'CommunityController@getmembers');


        //Community Technology
        Route::put('/communitytech/{community}', 'CommunityController@communitytech');

        // Event
        Route::post('/create_event', 'EventController@store');
        Route::put('/update_event/{event}', 'EventController@update');
        Route::delete('/event/{event}', 'EventController@destroy');
        Route::get('/event/{event}', 'EventController@eventdetails');
        Route::put('/event/check-attendance/{event}', 'EventController@checkAttendance');
        Route::put('/joinevent', 'EventController@joinevent');
        Route::put('/event/upload-profile/{event}', 'EventController@upload_profile');
        Route::put('/event/upload-payment/{event}', 'EventController@upload_payment');
        // Route::get('/event/members', 'EventController@getmembers');

        //Event Technology
        Route::put('/eventtech/{event}', 'EventController@eventtech');

        //Event Community
        Route::put('/eventcommunity/{community}', 'EventController@eventcommunity');

        // Notification
        Route::put('/reply-request', 'EventController@replyrequest');
    });

