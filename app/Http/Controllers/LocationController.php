<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{

    public function getLocation()
    {
        $user = Auth::user();

        $locations = Location::where('user_id', $user->id)->orderBy('created_at', 'desc') ->get();

        if ($locations->isNotEmpty()) {

            return response()->json(['data' => $locations]);
        }

        return response()->json(['message' => 'Location data not found in Database'], 404);
    }

    
    
    public function store(Request $request)
    {
        $request->validate([
            'longitude' => 'nullable',
            'latitude' => 'nullable',
        ]);
    
        $user = Auth::user();
        $location = new Location();
        $location->user_id = $user->id;
        $location->longitude = $request->input('longitude');
        $location->latitude = $request->input('latitude');
        $location->save();
    
        return response()->json(['message' => 'Location added to Redis and MySQL successfully'], 201);
    }

    public function showSingFollowUp($uuid)
    {   
       
       $data_list = AllInOneController::singledata('follow_ups','*','uuid',$uuid);

       foreach ($data_list as $key => $value) {
        $uuid = $value->uuid;
        $Owner = $value->Owner;
        $created_by = $value->created_by;

        $owner_list = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $Owner);
        $data_list[$key]->Owner = $owner_list;

        $created_by = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $created_by);
        $data_list[$key]->created_by = $created_by;

       }
    
   } 
}
