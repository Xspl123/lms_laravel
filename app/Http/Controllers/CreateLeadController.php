<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CreateLeadController extends Controller
{ 
    public function showSingleLead($uuid)
    {   
       
       $data_list = AllInOneController::singledata('create_leads','*','uuid',$uuid);

        return response([
            'data_list'=>$data_list,
            'status'=>'success'
        ], 200);

    }

    //show  leads
    public function userLead(){
        $column = AllInOneController::tabledetails_col("all_fields_columns","fieldsName,Column_Name,Column_order");
        $data_list = AllInOneController::getTableData("create_leads");
        
        return response([
            'column'=>$column,
            'data_list' => $data_list,
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
            $leads = new CreateLead;
            $leads->uuid = $uuid;
            $leads->lead_Name = $request->lead_Name;
            $leads->company = $request->company;;
            $leads->email = $request->email;
            $leads->fullName = $request->fullName;
            $leads->lead_Source = $request->lead_Source;
            $leads->lead_Owner = $lead_Owner;
            $leads->created_by = $username;
           // $leads->title = $request->title;
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

            Log::channel('create_leads')->info('A new lead has been created. lead data: '.$leads);

            $history = new History;
            $history->uuid = $uuid;
            $history->process_name  = 'leads';
            $history->created_by = $username;
            $history->feedback = 'Lead Created';
            $history->status = 'Add';
            $history->save();

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

    public function updateLead(Request $request, $uuid)
    {
        $updateLead = CreateLead::where('uuid', $uuid)->first();
       
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
        $searchTerm = $request->input('search_term');
        $searchlead = ApiHelperSearchData::search('create_leads', 'id', $searchTerm);

        // Do something with the search results, such as returning them as a response
        return response()->json(['message' => 'Searching Lead', 'searchlead' => $searchlead], 200);    }

    public function paginateData()
    {
        $paginateData = AllInOneController::getTableData('create_leads');
        return response()->json(['message' => 'Lead List', 'paginateData' => $paginateData], 200);
    }
    

}
