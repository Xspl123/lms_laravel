<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;

class CreateLeadController extends Controller
{ 
    public function showSingleLead($uuid)
     {   
       // $userId = Auth::id();
       
            //print_r($userId);exit;
        $leads = CreateLead::where('uuid',$uuid)->first();
        if (!$leads) {
            return response()->json([
                'success' => false,
                'message' => 'leads not found'
            ], 404);
        }
            else {

                // $result = DB::table('create_leads')
                // ->join('users', 'create_leads.id', '=', 'users.id')
                // ->select('users.id', 'users.uname', 'users.email')
                // ->get();

                //  $userArray = $result->toArray();

                //print_r($userArray); exit;
                
                // $result =  DB::table('create_leads')
                // ->join('users', 'create_leads.id', '=', 'users.id')
                // ->select('users.id', 'users.uname', 'users.email')
                // ->get();
                 //print_r($result); exit;
                return response()->json([
                    'success' => true,
                    'leads' => $leads,
                ]);
            }
        
    }

    //shwo  leads
    public function userLead(){
        $all_fields = DB::table('all_fields_columns')
         ->select('all_fields_columns.fieldsName','all_fields_columns.Column_Name')
        ->get();
        //print_r($all_fields);exit;
        $leads_count = DB::table('create_leads')->count();
        //print_r($leads_count);exit;
        $userId = Auth::id();
        $username = auth()->user()->uname;
       
        $leads = CreateLead::
                   select('create_leads.*')
                   ->where('lead_Owner', $username)
                   ->limit(7)
                   ->orderBy('id', 'desc')
                   ->get();
                   
        return response([
            'TotalRecord'=>$leads_count,
            'Column'=>$all_fields,
            'leads'=>$leads,
            'status'=>'success'
        ], 200);
    }
    //create  leads
    public function CreateUserLead(Request $request){

       
        $lead_Owner = Auth::user()->uname;
        $userId = Auth::id();
        $uuid = mt_rand(10000000, 99999999);
        $request->validate([
            'lead_Name' => 'required',
            'email' => 'required|email',
            'fullName' => 'required',
            'phone'=>'required',
            'lead_status' => 'required',
        ]);

        $get_user_details =  DB::table('create_leads')
        ->join('users', 'create_leads.id', '=', 'users.id')
        ->select('users.id', 'users.uname', 'users.email')
        ->where('users.id', $userId)
        ->get();

        $user_array = (array) $get_user_details;

        //$userArray = $get_user_details->toArray();
        //$jsn = json_decode($get_user_details, JSON_PRETTY_PRINT);
        print_r($get_user_details);exit;

        // if(CreateLead::where('email', $request->email)->first()){
        //     return response([
        //         'message' => 'Email already exists',
        //         'status'=>'failed'
        //     ], 200);
        // }

            $leads = new CreateLead;
            $leads->uuid = $uuid;
            $leads->lead_Name = $request->lead_Name;
            $leads->company = $request->company;
            $leads->email = $request->email;
            $leads->fullName = $request->fullName;
            $leads->lead_Source = $request->lead_Source;
            $leads->lead_Owner = $lead_Owner;
            $leads->created_by = $user_array;
            $leads->titel = $request->titel;
            $leads->fax = $request->fax;
            $leads->phone = $request->phone;
            $leads->mobile = $request->mobile;
            $leads->website = $request->website;
            $leads->lead_status = $request->lead_status;
            $leads->industry = $request->industry;
            $leads->rating = $request->rating;
            $leads->noOfEmployees = $request->noOfEmployees;
            $leads->annualRevenue = $request->annualRevenue;
            $leads->skypeID = $request->skypeID;
            $leads->secondaryEmail = $request->secondaryEmail;
            $leads->twitter = $request->twitter;
            $leads->street = $request->street;
            $leads->pinCode = $request->pinCode;
            $leads->state = $request->state;
            $leads->country = $request->country;
            $leads->discription = $request->discription;
            $leads->user_id = $userId;
            $leads->save();

        return response([
            'message' => 'Lead created Successfully',
            'status'=>'success',
            'leads' => $uuid
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
            return response()->json(['message' => 'Lead not found'], 404);
        }

        $updateLead->update($request->all());

        return response()->json(['message' => 'Lead updated', 'updateLead' => $updateLead], 200);
    
    
    }

    public function updateCreatedBy(Request $request, $id)
    {
        $updateCreatedBy = CreateLead::find($id);
        
        echo "<pre>";

        print_r($updateCreatedBy);
    }

    

}
