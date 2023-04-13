<?php
    namespace App\Services;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\Task;
    use App\Models\History;
    use Illuminate\Support\Facades\Log;
    class TaskService {

        public function insertData($data) { 

            $TaskOwner = Auth::user()->uname;
            $userId = Auth::id();
            $task = new Task;
            $uuid = mt_rand(10000000, 99999999);
            $task->TaskOwner = $userId;
            $task->Subject = $data['Subject'] ?? null;
            $task->DueDate = isset($data['DueDate']) ? $data['DueDate'] : null;
            $task->Status = $data['Status'] ?? null;
            $task->Priority = $data['Priority'] ?? null;
            $task->Reminder = $data['Reminder'] ?? null;
            $task->Repeat = $data['Repeat'] ?? null;
            $task->Description = $data['Description'] ?? null;
            $task->user_id = $userId;
            $task->p_id = isset($data['p_id']) ? $data['p_id'] : null;
            $task->uuid = $uuid; 
            $task->save();

            Log::channel('create_task')->info('Task has been created. task data: '.$task);
            
            $history = new History;
            $history->uuid = $uuid;
            $history->process_name  = 'Task';
            $history->created_by = $TaskOwner;
            $history->feedback = 'Task Created';
            $history->status = 'Add';
            $history->p_id = isset($data['p_id']) ? $data['p_id'] : null;

            $history->save();
        }

        public function updateData($id)
        {
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }
    
            $task->update($request->all());

            return $task;
        }

    }
