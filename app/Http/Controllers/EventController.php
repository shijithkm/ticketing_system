<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Ticket;
use App\Http\Resources\Ticket as TicketResource;
use App\Lineup;
use App\Http\Resources\Lineup as LineupResource;
use DB;

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

    public function allevents()
    {
        // Get events
        $events = Event::orderBy('title', 'asc')->get();

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
        $res = $event->save();
      
        if($res) {

             // Insert Tickets
             foreach ($request->input('tickets') as $k => $v) {
                $ticket = new Ticket;
                $ticket->event_id = $event->id;
                $ticket->ticket_type = $v['ticket_type'];
                $ticket->capacity = $v['capacity'];
                $ticket->price = $v['price'];
                $ticket->save();
             }

             // Insert Lineups
             foreach ($request->input('lineups') as $k => $v) {
                $lineup = new Lineup;
                $lineup->event_id = $event->id;
                $lineup->topic = $v['topic'];
                $lineup->speaker = $v['speaker'];
                $lineup->event_time = $v['event_time'];
                $lineup->save();
             }

        }

        return new EventResource($event);
        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tickets($id)
    {
        // Get Tickets
        $tickets = Event::find($id)->tickets;
        return $tickets;
    }



    public function sales()
    {
        // Get 
        // $sales =  DB::select("select e.title,t.ticket_type,t.capacity,t.price,count(r.email) sold from events e 
        // JOIN tickets t ON e.id = t.event_id
        // JOIN event_registrations r ON t.id = r.ticket_id
        // GROUP BY r.ticket_id  
        // ORDER BY `e`.`title` ASC")->get();
        // return $sales;

        $sales = DB::table('events')
        ->join('tickets', 'events.id', '=', 'tickets.event_id')
        ->join('event_registrations', 'tickets.id', '=', 'event_registrations.ticket_id')
        ->select('events.title', 'tickets.ticket_type', 'tickets.capacity','tickets.price', DB::raw('COUNT(event_registrations.id) as sold'))
        ->groupBy('event_registrations.ticket_id')
        ->where('event_registrations.created_at', '>=', now()->subMonths(6))
        ->get();

        
        return $sales;
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
