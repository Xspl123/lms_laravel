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
            $meeting->title = $data['title'] ?? null;
            $meeting->location = isset($data['location']) ? $data['location'] : null;
            $meeting->allday = $data['allday'] ?? null;
            $meeting->from = $formattedDateTime;
            $meeting->to = $data['to'] ?? null;
            $meeting->host = $Owner; //$data['host'] ?? request()->ip() // Get the user's IP address
            $meeting->participants = $data['participants'] ?? null;
            $meeting->related = $data['related'] ?? null;
            $meeting->contactName = $data['contactName'] ?? null;
            $meeting->contactNumber = $data['contactNumber'] ?? null;
            $meeting->repeat = $data['repeat'] ?? null;
            $meeting->participantsRemainder = $data['participantsRemainder'] ?? null;
            $meeting->description = $data['description'] ?? null;
            $meeting->reminder = $data['reminder'] ?? null;
            $meeting->save();
            Log::channel('create_meeting')->info('A new Meeting has been created. Meeting data: '.$meeting);
            return $meeting;
   
        }

        public function createHistory($meeting, $feedback, $status)
        {
            $history = new History;
            $history->uuid = $meeting->uuid;
            $history->process_name  = 'Meeting';
            $history->created_by = $meeting->host;
            $history->feedback = $feedback;
            $history->status = $status;
            $history->save();
            $history->save();
        }


    }
