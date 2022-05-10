<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EventRegistration;
use App\Http\Resources\EventRegistration as EventRegistrationResource;


class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // Get events
          $eventRegistrations = EventRegistration::orderBy('created_at', 'desc')->paginate(5);

          // Return collection of events as a resource
          return EventRegistrationResource::collection($eventRegistrations);
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
        $eventRegistration = new EventRegistration;
        $eventRegistration->ticket_id = $request->input('ticket_id');
        $eventRegistration->name = $request->input('name');
        $eventRegistration->email = $request->input('email');
        $eventRegistration->mobile = $request->input('mobile');
        $eventRegistration = $eventRegistration->save();
      
        if($res) {

            return new EventRegistration($eventRegistration);   
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
        //
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
        //
    }
}
