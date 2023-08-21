<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Helpers\CommonHelper;
use App\Helpers\TableHelper;
use App\Helpers\DataFetcher;
use App\Models\TempModule;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function createProfile(CreateProfileRequest $request)
    {
        $user = Auth::user();
        $created_by = $user->uname;

        $data = $request->validated();
        $data['created_by'] = $created_by;
        $data['modified_by'] = $created_by;

        $profile = new Profile($data);
        $profile->save();

        $tempModules = TempModule::all();
        
        foreach ($tempModules as $tempModule) {
            $module = new Module();
            $module->module_name = $tempModule->name;
            $module->profile_id = $profile->id;
            $module->save();
        }

        return response()->json(['message' => 'Profile and associated modules created successfully']);
    }

    public function showProfile()
    {
        $data_list=DataFetcher::getProfiles();
        return response()->json(['status' => 200,'message' => 'Profile List','data' => $data_list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
