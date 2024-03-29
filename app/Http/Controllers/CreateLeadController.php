<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use App\Models\History;
use App\Models\User;
use Predis\Client;
use App\Models\Role;
use App\Http\Controllers\AllInOneController;
use App\Helpers\TableHelper;
use Illuminate\Http\Request;
use App\Services\CreateLeadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Http\Requests\CreateLeadRequest;

class CreateLeadController extends Controller
{ 
    private $createLeadService;
    
    public function __construct(CreateLeadService $createLeadService)
    {
        $this->createLeadService = $createLeadService;
    }

    public function show($leadId)
    {
        $leadData = $this->createLeadService->getLeadData($leadId);

        if (empty($leadData)) {
            return response()->json(['error' => 'Lead not found'], 404);
        }

        return response()->json($leadData);
    }


    public function showSingleLead($uuid)
    {   
       
       $data_list = AllInOneController::singledata('create_leads','*','uuid',$uuid);

       foreach ($data_list as $key => $value) {
        $uuid = $value->uuid;
        $Owner = $value->Owner;
        $created_by = $value->created_by;

        $owner_list = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $Owner);
        $data_list[$key]->Owner = $owner_list;

        $created_by = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $created_by);
        $data_list[$key]->created_by = $created_by;

        
    }
        $Task_list = AllInOneController::singledata('tasks', ['Subject','Status','Priority','created_at'], 'p_id', $uuid);
        $data_list['tasks'] = $Task_list;
        $Task_list = AllInOneController::singledata('meetings', ['title','from','to','location'], 'p_id', $uuid);
        $data_list['meetings'] = $Task_list;

        return response([
            'data_list'=>$data_list,
            'status'=>'success'
        ], 200);

    }

    //show  leads
    public function userLead(){

        $column = AllInOneController::tabledetails_col("all_fields_columns","fieldsName,Column_Name,Column_order");
        //$data_list = AllInOneController::getTableData('create_leads','*');
        $data_list=TableHelper::getTableData('create_leads', ['*']);
        //print_r($data_list);exit;

        foreach ($data_list as $key => $value) {
            $uuid = $value->uuid;
            $Owner = $value->Owner;

            $relatedData = AllInOneController::singledata('meetings', ['title','from','to'], 'p_id', $uuid);
 
            $data_list[$key]->related_activities = $relatedData;
            $data_list[$key]->number_of_meetting = $relatedData->count();
            $owner_list = AllInOneController::singledata('users', ['id','uname','urole','email'], 'id', $Owner);
            $data_list[$key]->Owner = $owner_list;
        }
        return response(['column'=>$column,'data_list' => $data_list, 'status'=>'success'], 200);
    }


    
    //show leadWithUserRole
    public function leadWithUserRole(){
        $user = Auth::user();
        $role_id = $user->role_id;
        // $role = Role::find($role_id);
        // print_r($role); exit;
        // $role_name = $role->name;
        // print_r($role_name); exit;
        // $role_id = $role->id;
        // $user_id = $user->id;
       // print_r($user); exit;
        $leads = $this->createLeadService->getdata(19);
        if (isset($leads->message)) {
            // Display the error message to the user
            echo $leads->message;
        } else {
            // Display the data to the user
            return response(['leads' => $leads], 200);
        }
 
    }
    //create  leads
    public function CreateUserLead(CreateLeadRequest $request ,CreateLeadService $createLeadService)
    {   
        $data = $request->validated();
        $lead = $createLeadService->insertData($data);
        $createLeadService->createLeadHistory($lead, 'Lead Created', 'Add');
        return response()->json(['message' => 'Lead created successfully','data' => $lead,]);
    }

    //delete lead  behaf of id.

    public function destroyLead($uuid)
    {
        return $this->createLeadService->deleteLead($uuid);
    }

    //update lead  behaf of uuid.
    public function updateLead(Request $request, $uuid)
    {
        
        return $this->createLeadService->updateLead($request, $uuid);

    }

    public function deleteAllLeads()
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Delete only the leads belonging to the authenticated user
        CreateLead::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Your leads deleted successfully'], 200);
    }

    public function searchLead(Request $request)
    {
        $searchTerm = $request->input('search_term');

        // Check if the search term is valid
        if (empty($searchTerm)) {
            return response()->json(['message' => 'Invalid search term'], 400);
        }
        
        $data_list = ApiHelperSearchData::search('create_leads', $searchTerm);
        
        if ($data_list->total() > 0) 
        {
            foreach ($data_list as $key => $value) {
                $uuid = $value->uuid;
                $Owner = $value->Owner;
        
                $relatedData = AllInOneController::singledata('meetings', ['title', 'from', 'to'], 'p_id', $uuid);
        
                $data_list[$key]->related_activities = $relatedData;
                $data_list[$key]->number_of_meetting = $relatedData->count();

                $owner_list = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $Owner);
                $data_list[$key]->Owner = $owner_list;
            }
        
            // Rows found, do something with the data
            return response()->json(['message' => 'Lead found', 'lead' => $data_list], 200);
        } 
        else 
        {
            // No leads found
            return response()->json(['message' => 'No leads found'], 404);
        } 
    }




    

    public function paginateData()
    {   
        echo "paginateData";
    }

    //count lead  status wise 
    public function getLeadCount()
    {
        $leadStatuses = ['Pre-Qualified', 'Not-Qualified', 'Junk Lead', 'Not Contacted', 'Lost Lead','active','Follow up','open','Attempted to Contact','Contact in Future','inactive'];
        $leadCount = $this->createLeadService->getLeadCount($leadStatuses);

        return response()->json(['status_wise_lead_count' => $leadCount]);
    }

}
