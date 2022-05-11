<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','AuthController@login');

Route::group(['middleware'=>'jwt.verify'],function(){
    
    Route::get('user','AuthController@getUser');
    // List events
    Route::get('events', 'EventController@index');
    
    Route::get('events/all', 'EventController@allevents');

    // List single event
    Route::get('event/{id}', 'EventController@show');

    // List Tikets Based On Event id
    Route::get('event/{id}/tickets', 'EventController@tickets');

    // Create new event
    Route::post('event', 'EventController@store');

    // Update event
    Route::put('event', 'EventController@store');

    // Delete event
    Route::delete('event/{id}', 'EventController@destroy');

    // List tickets
    Route::get('tickets', 'TicketsController@index');

    // Create ticket
    Route::post('ticket', 'TicketsController@store');

    // Update ticket
    Route::put('ticket', 'TicketsController@store');

    // Delete ticket
    Route::delete('ticket/{id}', 'TicketsController@destroy');

    // List Event Registrations
    Route::get('registrations', 'EventRegistrationController@index');

    // Event Registration
    Route::post('register', 'EventRegistrationController@store');

    // Sales Report
    Route::get('sales', 'EventController@sales');
});


