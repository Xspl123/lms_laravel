<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Helpers\TableHelper;
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
        $meetingService->createHistory($meeting, 'Meeting Created', 'Add');
        return response(['message' => 'Meeting has been created Successfully','status'=>'success','meeting' => $meeting], 200);

    }

    public function showMeetings(Request $request)
    {
        $meetings = TableHelper::getTableData('meetings', ['*']);
        return response(['meetings' =>$meetings,'status'=>'success'], 200);
    }


    public function showSingMeetings($id)
    {   
       
       $singelMeeting = AllInOneController::singledata('meetings','*','id',$id);

        return response([
            'singelMeeting'=>$singelMeeting,
            'status'=>'success'
        ], 200);

    }

   

    public function updateMeetings(Request $request, Meeting $meeting,$id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return response()->json(['message' => 'Meeting not found']);
        }

        $meeting->update($request->all());
        
        return response()->json(['message' => 'Meeting updated successfully']);
    }

   
    public function deleteMeetings(Meeting $meeting,$id)
    {
       $meeting = Meeting::find($id);
    
       if (!$meeting) {
        return response()->json(['message' => 'Meeting not found'], 404);
       }
       $meeting->delete();
       return response()->json (['message' => 'Meeting deleted successfully']);
    }
}
