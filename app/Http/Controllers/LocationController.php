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
    
        // Save the location data in Redis
        Redis::hmset("user:{$user->id}:location", [
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
        ]);
    
        // Set the expiration time to 24 hours (86400 seconds)
        Redis::expire("user:{$user->id}:location", 86400);
        $location = new Location();
        $location->user_id = $user->id;
        $location->longitude = $request->input('longitude');
        $location->latitude = $request->input('latitude');
        $location->save();
    
        return response()->json(['message' => 'Location added to Redis and MySQL successfully'], 201);
    }
    

    

   
}
