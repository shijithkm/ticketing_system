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
use Exception;
use Illuminate\Support\Facades\Validator;

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
        return response()->json($events);
    }

    public function allevents()
    {
        // Get events
        $events = Event::orderBy('title', 'asc')->get();
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'tickets' => 'required',
            'lineups' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

        $event = new Event;
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

        return response()->json($event);

    }
    catch(\Exception $e){
        return response()->json(['status'=> false, 'message' => "Internal Server Error" ],500);
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
        return response()->json($event);
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
        return response()->json($tickets);
    }


    
    public function validateCapacity($ticket_id)
    {
   
        $capacity = DB::table('events')
        ->join('tickets', 'events.id', '=', 'tickets.event_id')
        ->join('event_registrations', 'tickets.id', '=', 'event_registrations.ticket_id')
        ->select('events.title', 'tickets.ticket_type', 'tickets.capacity','tickets.price', DB::raw('COUNT(event_registrations.id) as sold'))
        ->groupBy('event_registrations.ticket_id')
        ->where('event_registrations.ticket_id', '=', $ticket_id)
        ->orderBy('events.title')
        ->get();

        
        return response()->json($capacity[0]);
    }
  


    public function sales()
    {
   
        $sales = DB::table('events')
        ->join('tickets', 'events.id', '=', 'tickets.event_id')
        ->join('event_registrations', 'tickets.id', '=', 'event_registrations.ticket_id')
        ->select('events.title', 'tickets.ticket_type', 'tickets.capacity','tickets.price', DB::raw('COUNT(event_registrations.id) as sold'))
        ->groupBy('event_registrations.ticket_id')
        ->where('event_registrations.created_at', '>=', now()->subMonths(6))
        ->orderBy('events.title')
        ->get();

        
        return response()->json($sales);
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
            return response()->json($event);
        }    
    }
}
