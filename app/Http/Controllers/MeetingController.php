<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Helpers\TableHelper;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Http\Request;
use App\Services\MeetingService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateMeetingRequest;

class MeetingController extends Controller
{
   
    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

 
    public function createMeeting(CreateMeetingRequest $request, MeetingService $meetingService)
    {
        $data = $request->validated();
        $meeting = $this->meetingService->insertData($data);
        $p_id=$data['p_id'];
         
        $meetingService->createHistory($meeting, 'Meeting Created', 'Add',$p_id);
        return response(['message' => 'Meeting has been created Successfully','status'=>'success','meeting' => $meeting], 200);

    }

    public function showMeetings(Request $request)
    {
        $meetings = TableHelper::getTableData('meetings', ['*']);

        foreach ($meetings as $key => $value) {
            $p_id = $value->p_id;
            $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
            $meetings[$key]->related = $relatedData;
        }

        return response(['meetings' =>$meetings,'status'=>'success'], 200);
    }


    public function showSingMeetings($uuid)
    {
       $singelMeeting = AllInOneController::singledata('meetings','*','uuid',$uuid);

       foreach ($singelMeeting as $key => $value) {
        $p_id = $value->p_id;
        $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
        $singelMeeting[$key]->leads = $relatedData;
    }

        return response([
            'singelMeeting'=>$singelMeeting,
            'status'=>'success'
        ], 200);

    }

   

    public function updateMeetings(Request $request, $uuid)
    {
        return $this->meetingService->updateAccount($request, $uuid);
    }

   
    public function deleteMeetings(Request $request, $id)
    {
        $result = TableHelper::deleteIfOwner(new Meeting(), $id);
        
        if ($result) {
            return response()->json(['message' => 'Meeting deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized or meeting not found'], 403);
        }
    }

    public function deleteAllMeetings()
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $owner_id = Auth::user();

        // Delete only the leads belonging to the authenticated user
        Meeting::where('owner_id', $owner_id->id)->delete();

        return response()->json(['message' => 'Your meetings deleted successfully'], 200);
    }

    public function search(Request $request)
    {
        $table = 'meetings'; // Replace with your actual table name
        $searchTerm = $request->input('search_term');

        // Call the search function from the helper class
        $results = ApiHelperSearchData::searchOwner($table, $searchTerm);

        // Return the results as JSON response
        return response()->json(['results' => $results]);
    }
}
