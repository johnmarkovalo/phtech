<?php

use Illuminate\Http\Request;

    Route::post('/login', 'AuthController@login')->name('login.api');
    Route::post('/register', 'AuthController@register')->name('register.api');
    Route::get('/technology', 'TechnologyController@index');

    // private routes
    Route::middleware('auth:api')->group(function () {
        // Get current logged in user
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
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
        Route::get('/community', 'CommunityController@index');
        Route::post('/community', 'CommunityController@store');
        Route::put('/community/{community}', 'CommunityController@update');
        Route::delete('/community/{community}', 'RequestController@destroy');

        //Information Technology
        Route::put('/infotech/{information}', 'InformationController@infotech');
    });

