<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;

class CreateLeadController extends Controller
{ 
    //shwo  leads
    public function userLead(){
        
        $userId = Auth::id();
        $leads = CreateLead::join('users', 'create_leads.user_id', '=', 'users.id')
                   ->select('create_leads.*')
                   ->where('users.id', $userId)
                   ->orderBy('id', 'desc')
                   ->get();
                   
        return response([
            'leads'=>$leads,
            'status'=>'success'
        ], 200);
    }
    //create  leads
    public function CreateUserLead(Request $request){
        $lead_Owner = Auth::user()->uname;
        $userId = Auth::id();

        $request->validate([
            'lead_Name' => 'required',
            'company' => 'required|string',
            'email' => 'required|email',
            'lead_Source' => 'required',
            'first_Name' => 'required',
            'last_Name' => 'required',
            'titel' => 'required',
            'fax' => 'required',
            'mobile'=>'required',
            'website' =>'required',
            'lead_status' => 'required',
            'industry' => 'required',
            'tr' => 'required',
        ]);
        if(CreateLead::where('email', $request->email)->first()){
            return response([
                'message' => 'Email already exists',
                'status'=>'failed'
            ], 200);
        }


        $leads = CreateLead::create([
            'lead_Name' => $request->lead_Name,
            'company' => $request->company,
            'email' => $request->email,
            'lead_Source' => $request->lead_Source,
            'lead_Owner' => $lead_Owner,
            'first_Name' => $request->first_Name,
            'last_Name' => $request->last_Name,
            'titel' => $request->titel,
            'fax' => $request->fax,
            'mobile'=> $request->mobile,
            'website'=> $request->website,
            'lead_status'=> $request->lead_status,
            'industry'=> $request->industry,
            'tr'=> $request->tr,
            'user_id' => $userId

        ]);

        return response([
            'message' => 'Lead created Successfully',
            'status'=>'success'
        ], 200);
    }


    public function destroyLead($id)
    {
        $leads = CreateLead::find($id);

        if (!$leads) {
            return response()->json(['message' => 'Lead not found'], 404);
        }

        $leads->delete();

        return response()->json(['message' => 'Lead deleted'], 200);
    }

    public function updateLead(Request $request, $id)
    {
        $updateLead = CreateLead::find($id);

        if (!$updateLead) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $updateLead->update($request->all());

        return response()->json(['message' => 'Lead updated', 'updateLead' => $updateLead], 200);
    }
    

}
