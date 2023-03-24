<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiHelperSearchData;

class CreateLeadController extends Controller
{ 
    public function showSingleLead($uuid)
    {   
       // $cname = AllInOneController::tabledetails_col('companies','*','uuid',$uuid );
        
       $data_list = AllInOneController::singlelead('create_leads','*','uuid',$uuid);
        return response([
            
            'data_list'=>$data_list,
            
            'status'=>'success'
        ], 200);

    }

    //show  leads
    public function userLead(){
        $data_list = AllInOneController::tabledetails_col("create_leads","*");
        $column = AllInOneController::tabledetails_col("all_fields_columns","fieldsName,Column_Name,Column_order");
        return response([
            'data_list'=>$data_list,
            'column' => $column,
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
            'phone'=>[
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{10}$/', $value)) {
                        $fail('The phone must be exactly 10 digits.');
                    }
                },
            ],
            'lead_status' => 'required',
        ]);
           
            $username = Auth::user()->uname;
            // $get_user_details =  DB::table('create_leads')
            // ->join('users', 'create_leads.id', '=', 'users.id')
            // ->select('users.uname')
            // ->where('users.id', $userId)
            // ->get();

           // print_r($username);exit;

            $leads = new CreateLead;
            $leads->uuid = $uuid;
            $leads->lead_Name = $request->lead_Name;
            $leads->company = $request->company;;
            $leads->email = $request->email;
            $leads->fullName = $request->fullName;
            $leads->lead_Source = $request->lead_Source;
            $leads->lead_Owner = $lead_Owner;
            $leads->created_by = $username;
            $leads->title = $request->title;
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

    public function deleteAllLeads()
    {
        $task = CreateLead::truncate();

        return response()->json(['message' => 'All tasks deleted successfull'], 200);

    }

    public function searchlead(Request $request)
    {
        $searchlead = CreateLead::query();
        $searchleadData = ApiHelperSearchData::search($searchlead, $request, 'create_leads', true);
        return response()->json([
            'employee' => $searchleadData['results'],
            'employee_count' => $searchleadData['total_count'],
        ]);
    }

    

}
