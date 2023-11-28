<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AllInOneController;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\CreateLead; 
use App\Models\User;
use App\Models\History;
use Auth;
class FollowUpController extends Controller
{
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'p_id' => 'required|exists:create_leads,id',
            'uuid' => 'required|exists:create_leads,uuid',
            'remark' => 'required',
        ]);

        $followup = new FollowUp([
            'p_id' => $request->input('p_id'),
            'uuid' => $request->input('uuid'),
            'create_by' => auth()->user()->id,
            'remark' => $request->input('remark'),
        ]);

        $followup->save();
        
        $history = new History;
        $history->uuid = $request->uuid;
        $history->process_name  = 'FollowUp';
        $history->created_by = auth()->user()->uname;
        $history->feedback = $request->input('remark');
        $history->status = 'ADD';
        $history->save();
        
        return response()->json(['message' => 'Followup created successfully'], 201);

    }

    public function updateFollowUp(Request $request, $uuid)
    {
        $followup = FollowUp::where('uuid', $uuid)->first();
        //print_r($followup);exit;
        if (!$followup) {
            return response()->json(['message' => 'FollowUp not found'], 404);
        }

        $originalData = clone $followup;

        $followup->update($request->all());
        //print_r($followup);exit;
        $changes = $followup->getChanges();

        if (empty($changes)) {
            return response()->json(['message' => 'No changes detected'], 400);
        }
        $column = key($changes);
        $before = $originalData->$column;
        $after = $changes[$column];
        $feedback = "$column was FollowUp from $before to $after";

        $history = new History;
        $history->uuid = $uuid;
        $history->process_name = 'FollowUp';
        $history->created_by = Auth::user()->uname;
        $history->feedback = $feedback;
        $history->status = 'Update';
        $history->save();
    
        return response()->json(['message' => 'FollowUp has been updated'], 200);
    } 

    public function showSingFollowUp($uuid)
    {   
       
       $data_list = AllInOneController::singledata('follow_ups','*','uuid',$uuid);

       foreach ($data_list as $key => $value) {
        $uuid = $value->uuid;
        // $Owner = $value->Owner;
        $create_by = $value->create_by;

        // $owner_list = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $Owner);
        // $data_list[$key]->Owner = $owner_list;

        $create_by = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $create_by);
        $data_list[$key]->created_by = $create_by;

       }

    return response()->json(['data_list' =>$data_list], 200);
    
   } 
}
