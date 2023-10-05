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
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

  
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
        $data_list = Profile::all();
        return response()->json(['status' => 200,'message' => 'Profile List','data' => $data_list]);
    }

 
    public function singleProfile($id)
    {
        $profile = Profile::with('modules')->find($id);

        if ($profile) {
            return response()->json(['status' => 200, 'message' => 'Profile List', 'data' => $profile]);
        } else {
            return response()->json(['status' => 404, 'message' => 'Profile not found', 'data' => null]);
        }
    }
    

   
    public function updateProfile(Request $request, $id)
    {
        $profile = Profile::with('modules')->find($id);
    
        if (!$profile) {
            return response()->json(['status' => 404, 'message' => 'Profile not found']);
        }
    
        $moduleName = $request->input('module_name');
    
        // Update fields in the profiles table
        $profile->update($request->except('module_name'));
    
        // Update fields in the associated modules
        if ($profile->modules) {
            foreach ($profile->modules as $module) {
                if ($module->module_name === $moduleName) {
                    $fieldsToUpdate = [];
                    if ($module->module_name === 'Lead' || $module->module_name === 'Task' || $module->module_name === 'Meeting') {
                        // Assuming 'view', 'create', 'edit', 'delete' fields are present in the module model
                        $fieldsToUpdate = ['view', 'create', 'edit', 'delete'];
                    }
    
                    // Update module fields
                    $module->update($request->only($fieldsToUpdate));
                }
            }
        }
    
        return response()->json(['status' => 200, 'message' => 'Profile and associated modules updated successfully']);
    }
    

   
    public function destroy(Profile $profile)
    {
        //
    }
}
