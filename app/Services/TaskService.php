<?php
    namespace App\Services;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\Task;

    class TaskService {

        public function insertData($data) { 

            $TaskOwner = Auth::user()->uname;
            $userId = Auth::id();

            $task = new Task;
            $task->TaskOwner = $TaskOwner;
            $task->Subject = $data['Subject'] ?? null;
            $task->DueDate = isset($data['DueDate']) ? $data['DueDate'] : null;
            $task->Status = $data['Status'] ?? null;
            $task->Priority = $data['Priority'] ?? null;
            $task->Reminder = $data['Reminder'] ?? null;
            $task->Repeat = $data['Repeat'] ?? null;
            $task->Description = $data['Description'] ?? null;
            $task->user_id = $userId;
            $task->save();
            return $task;
            
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
