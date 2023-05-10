<?php

namespace App\Http\Controllers;
use App\Models\CreateLead;
use App\Models\AllFieldsColumn;
use App\Models\History;
use App\Models\User;
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
    
    public function __construct(CreateLeadService $createLeadService)
    {
        $this->createLeadService = $createLeadService;
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
        //$data_list = AllInOneController::getTableData('create_leads','*');
        
        $leads = $this->createLeadService->getLeads();
        
        return response(['column'=>$column,'leads' => $leads, 'status'=>'success'], 200);
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
        $updateLead = CreateLead::where('uuid', $uuid)->first();
        if (!$updateLead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }

        $originalData = clone $updateLead;

        $updateLead->update($request->all());

        $changes = $updateLead->getChanges();

        if (empty($changes)) {
            return response()->json(['message' => 'No changes detected'], 400);
        }
        $column = key($changes);
        $before = $originalData->$column;
        $after = $changes[$column];
        $feedback = "$column was updated from $before to $after";

        $history = new History;
        $history->uuid = $uuid;
        $history->process_name = 'leads';
        $history->created_by = Auth::user()->uname;
        $history->feedback = $feedback;
        $history->status = 'Updated';
        
        $history->save();
        Log::channel('update_leads')->info("Lead has been updated. $feedback");

        return response()->json(['message' => 'Lead has been updated'], 200);

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
        $role= new RoleController;
        $getRole = $role->getRolesHierarchy();
        $getRole = $this->role()->with('childRoles')->get();
        $roleIds = $role->pluck('id')->toArray();
        $childRoleIds = $role->flatMap(function ($role) {
            return $role->childRoles->pluck('id');
        })->toArray();
    
        return CreateLead::whereIn('user_id', function ($query) use ($roleIds, $childRoleIds) {
            $query->select('id')
                ->from('users')
                ->join('roles', 'users.id', '=', 'roles.user_id')
                ->whereIn('role_user.role_id', array_merge($roleIds, $childRoleIds));
        })->get();
    }

    
   

}
