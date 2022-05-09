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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List events
Route::get('events', 'EventController@index');

// List single event
Route::get('event/{id}', 'EventController@show');

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