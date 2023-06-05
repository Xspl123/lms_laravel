<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use App\Models\History;
use App\Models\User;
use Predis\Client;
use App\Models\Role;
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

        return response([
            'data_list'=>$data_list,
            'status'=>'success'
        ], 200);

    }

    //show  leads
    public function userLead(){

        $column = AllInOneController::tabledetails_col("all_fields_columns","fieldsName,Column_Name,Column_order");
        $data_list = AllInOneController::getTableData('create_leads','*');
        return response(['column'=>$column,'leads' => $data_list, 'status'=>'success'], 200);
    }
    //show leadWithUserRole
    public function leadWithUserRole(){
        $leads = $this->createLeadService->getdata(18);
        if (isset($account->message)) {
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
        return $this->createLeadService->updateLead($request, $uuid);
    }

    public function deleteAllLeads()
    {
        $leads = CreateLead::truncate();

        return response()->json(['message' => 'All Lead deleted successfull'], 200);

    }

    public function searchlead(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $searchlead = ApiHelperSearchData::search('create_leads', 'id', $searchTerm);

        // Do something with the search results, such as returning them as a response
        return response()->json(['message' => 'Searching Lead', 'searchlead' => $searchlead], 200);    }

    public function paginateData()
    { 
        echo "paginateData";
    }


    public function getLeadCount()
    {
        $leadStatuses = ['Pre-Qualified', 'Not-Qualified', 'Junk Lead', 'Not Contacted', 'Lost Lead','active','Follow up','open','Attempted to Contact','Contact in Future','inactive'];
        $leadCount = $this->createLeadService->getLeadCount($leadStatuses);

        return response()->json(['status_wise_lead_count' => $leadCount]);
    }

}
