<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\Http\Resources\Event as EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get events
        $events = Event::orderBy('created_at', 'desc')->paginate(5);

        // Return collection of events as a resource
        return EventResource::collection($events);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $request->isMethod('put') ? Event::findOrFail($request->event_id) : new Event;

        $event->id = $request->input('event_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->event_start_date = $request->input('event_start_date');
        $event->event_end_date = $request->input('event_end_date');

        if($event->save()) {
            return new EventResource($event);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get event
        $event = Event::findOrFail($id);

        // Return single event as a resource
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get event
        $event = Event::findOrFail($id);

        if($event->delete()) {
            return new EventResource($event);
        }    
    }
}
