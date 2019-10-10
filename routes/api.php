<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['json.response']], function () {
    // public routes
    Route::post('/login', 'AuthController@login')->name('login.api');
    Route::post('/register', 'AuthController@register')->name('register.api');

    // private routes
    Route::middleware('auth:api')->group(function () {
        // Get current logged in user
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // Logout
        Route::get('/logout', 'AuthController@logout')->name('logout');
        
        // Item
        Route::get('/item', 'ItemController@index');
        Route::get('/item/{item}', 'ItemController@show');
        Route::post('/item', 'ItemController@store');
        Route::put('/item/{item}', 'ItemController@update');
        Route::delete('/item/{item}', 'ItemController@destroy');

        // Customer
        Route::get('/customer', 'CustomerController@index');
        Route::post('/customer', 'CustomerController@store');
        Route::put('/customer/{customer}', 'CustomerController@update');
        Route::delete('/customer/{customer}', 'CustomerController@destroy');

        // Request
        Route::get('/request/customer-usernames', 'RequestController@usernames');
        Route::get('/request/item-codes', 'RequestController@item_codes');
        Route::get('/request/{request_obj}/details', 'RequestController@details');
        Route::put('/request/{request_obj}/status', 'RequestController@request_status');
        Route::get('/request', 'RequestController@index');
        Route::post('/request', 'RequestController@store');
    });
});

