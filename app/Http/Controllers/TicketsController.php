<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ticket;
use App\Http\Resources\Ticket as TicketResource;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // Get tickets
          $tickets = Ticket::orderBy('created_at', 'desc')->paginate(5);

          // Return collection of tickets as a resource
          return TicketResource::collection($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $ticket = $request->isMethod('put') ? Ticket::findOrFail($request->ticket_id) : new Ticket;

        $ticket->id = $request->input('ticket_id');
        $ticket->event_id = $request->input('event_id');
        $ticket->ticket_type = $request->input('ticket_type');
        $ticket->capacity = $request->input('capacity');
        $ticket->price = $request->input('price');

        if($ticket->save()) {
            return new TicketResource($ticket);
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
        // Get Ticket
        $ticket = Ticket::findOrFail($id);

        // Return single ticket as a resource
        return new TicketResource($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Get Ticket
         $ticket = Ticket::findOrFail($id);

         if($ticket->delete()) {
             return new TicketResource($ticket);
         }    
    }
}
