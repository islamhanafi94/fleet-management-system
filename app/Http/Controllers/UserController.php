<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TripSeats;
use App\Models\Trip;

class UserController extends Controller
{

    public function index(){
        return response()->json(["name" => "islam"]);
    }

    public function book(Request $request) {
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|exists:trips,id|Integer',
            'from' => 'required|Integer',
            'to' => 'required|Integer',
            'seat_id' => 'required|Integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $trip_id = $request->get('trip_id');
        $from = $request->get('from');
        $to = $request->get('to');
        $seat_id = $request->get('seat_id');
        $user_id = $request->user()->id;

        $trip = Trip::find($trip_id);

        return $trip->addPassenger($user_id,$from,$to,$seat_id);
        
    }

    public function getAvailableSeats(Request $request) {

        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|exists:trips,id|Integer',
            'from' => 'required|Integer',
            'to' => 'required|Integer',
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


 
        $trip_id = $request->get('trip_id');
        $from = $request->get('from');
        $to = $request->get('to');

        $trip = Trip::find($trip_id);

        if (!$trip->hasValidStations($from,$to)){
            return response()->json(["error" => "Invalid Stations"], 422);
        }

        return $trip->emptySeats($from);
    }

}
