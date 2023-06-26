<?php
    namespace App\Services;
    use App\Models\Meeting;
    use App\Models\History;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    use App\Models\Task;
    use Illuminate\Support\Facades\Log;

    class MeetingService {

        public function insertData($data) 
        { 
            $currentDateTime = Carbon::now();
            $formattedDateTime = $currentDateTime->format('M d, Y g:i');        
            $Owner = Auth::user()->uname;          
            $meeting = new Meeting; // changed $meetings to $meeting
            $meeting->uuid = $uuid = mt_rand(10000000, 99999999); // changed $meetings to $meeting and removed duplicate assignment of $uuid
            $meeting->p_id =  $data['p_id'] ?? null;
            $meeting->title = $data['title'] ?? null;
            $meeting->location = isset($data['location']) ? $data['location'] : null;
            $meeting->allday = $data['allday'] ?? null;
            $meeting->from = $data['from'] ?? null;
            $meeting->to = $data['to'] ?? null;
            $meeting->host = $data['host'] ?? null; //$data['host'] ?? request()->ip() // Get the user's IP address
            $meeting->participants = $data['participants'] ?? null;
            $meeting->related = $data['related'] ?? null;
            $meeting->contactName = $data['contactName'] ?? null;
            $meeting->contactNumber = $data['contactNumber'] ?? null;
            $meeting->repeat = $data['repeat'] ?? null;
            $meeting->participantsRemainder = $data['participantsRemainder'] ?? null;
            $meeting->description = $data['description'] ?? null;
            $meeting->reminder = $data['reminder'] ?? null;
            $meeting->owner_id = auth()->user()->id;
            $meeting->created_by = auth()->user()->id;
            $meeting->save();
            Log::channel('create_meeting')->info('A new Meeting has been created. Meeting data: '.$meeting);
            return $meeting;
   
        }

        public function createHistory($meeting, $feedback, $status,$p_id)
        {
            $history = new History;
            $history->uuid = $meeting->uuid;
            $history->p_id=$p_id;
            $history->process_name  = 'Meeting';
            $history->created_by = auth()->user()->id;
            $history->feedback = $feedback;
            $history->status = $status;
            $history->save();
            
        }


        public function updateAccount(Request $request, $uuid)
        {
            $meeting = Meeting::where('uuid', $uuid)->first();
            if (!$meeting) {
                return response()->json(['message' => 'meeting not found'], 404);
            }

            $originalData = clone $meeting;

            $meeting->update($request->all());

            $changes = $meeting->getChanges();

            if (empty($changes)) {
                return response()->json(['message' => 'No changes detected'], 400);
            }
            $column = key($changes);
            $before = $originalData->$column;
            $after = $changes[$column];
            $feedback = "$column was updated from $before to $after";

            $history = new History;
            $history->uuid = $uuid;
            $history->process_name = 'meeting';
            $history->created_by = Auth::user()->uname;
            $history->feedback = $feedback;
            $history->status = 'Updated';
            
            $history->save();
        
            return response()->json(['message' => 'meeting has been updated'], 200);
        }


    }
