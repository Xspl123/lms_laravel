<?php
    namespace App\Services;
    use App\Models\Meeting;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    use App\Models\Task;

    class MeetingService {

        public function insertData($data) { 

            $currentDateTime = Carbon::now();
            $formattedDateTime = $currentDateTime->format('M d, Y g:i');
            
            $Owner = Auth::user()->uname;
            
            $meetings = new Meeting;
            $meetings->title = $data['title'] ?? null;
            $meetings->location = isset($data['location']) ? $data['location'] : null;
            $meetings->allday = $data['allday'] ?? null;
            $meetings->from = $formattedDateTime;
            $meetings->to = $data['to'] ?? null;
            $meetings->host = $Owner; //$data['host'] ?? request()->ip() // Get the user's IP address
            $meetings->participants = $data['participants'] ?? null;
            $meetings->related = $data['related'] ?? null;
            $meetings->contactName = $data['contactName'] ?? null;
            $meetings->contactNumber = $data['contactNumber'] ?? null;
            $meetings->repeat = $data['repeat'] ?? null;
            $meetings->participantsRemainder = $data['participantsRemainder'] ?? null;
            $meetings->description = $data['description'] ?? null;
            $meetings->reminder = $data['reminder'] ?? null;
            $meetings->save();
            return $meetings;
            
        }

    }
