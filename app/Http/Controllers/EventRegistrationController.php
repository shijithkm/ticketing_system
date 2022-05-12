<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EventRegistration;
use App\Http\Resources\EventRegistration as EventRegistrationResource;
use Exception;
use Illuminate\Support\Facades\Validator;


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
          return response()->json($eventRegistrations);
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
            'ticket_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> false, 'message' => $validator->errors()],422);
        }

        try{

        $eventRegistration = new EventRegistration;
        $eventRegistration->ticket_id = $request->input('ticket_id');
        $eventRegistration->name = $request->input('name');
        $eventRegistration->email = $request->input('email');
        $eventRegistration->mobile = $request->input('mobile');
        $res = $eventRegistration->save();
      
        return response()->json($eventRegistration);

    }
    catch(\Exception $e){
        return response()->json(['status'=> false, 'message' => "Internal Server Error" ],500);
    }
        
    }

}
