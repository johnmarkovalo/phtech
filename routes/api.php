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

        //Get all users
        Route::get('/users', 'UserController@index');

        // Logout
        Route::post('/logout', 'AuthController@logout')->name('logout');
        
        // Technology
        Route::post('/technology', 'TechnologyController@store');
        Route::put('/technology/{technology}', 'TechnologyController@update');
        Route::delete('/technology/{technology}', 'TechnologyController@destroy');
        
        // Information
        Route::get('/information', 'InformationController@index');
        // Route::get('/information/{information}', 'InformationController@show');
        Route::put('/information/{information}', 'InformationController@update');
        Route::delete('/information/{information}', 'InformationController@destroy');

        //Information Technology
        Route::put('/infotech/{information}', 'InformationController@infotech');

        // Community
        Route::post('/community', 'CommunityController@store');
        Route::put('/community/{community}', 'CommunityController@update');
        Route::delete('/community/{community}', 'CommunityController@destroy');
        Route::get('/community/{community}', 'CommunityController@communitydetails');
        Route::get('/communityunder', 'CommunityController@communityunder');
        Route::put('/joincommunity', 'CommunityController@joincommunity');

        // Route::get('/community/members', 'CommunityController@getmembers');


        //Community Technology
        Route::put('/communitytech/{community}', 'CommunityController@communitytech');

        // Event
        Route::post('/event', 'EventController@store');
        Route::put('/event/{event}', 'EventController@update');
        Route::delete('/event/{event}', 'EventController@destroy');
        Route::get('/event/{event}', 'EventController@eventdetails');
        Route::put('/joinevent', 'EventController@joinevent');
        // Route::get('/event/members', 'EventController@getmembers');

        //Event Technology
        Route::put('/eventtech/{event}', 'EventController@eventtech');

        //Event Community
        Route::put('/eventcommunity/{community}', 'EventController@eventcommunity');
    });

