<?php
    namespace App\Services;
    use App\Models\History;
    use App\Models\Task;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    
    class TaskService
    {
        public function createTask(array $data): Task
        {
            $owner = Auth::user()->uname;
            $userId = Auth::id();
            $task = new Task;
            $uuid = mt_rand(10000000, 99999999);
            $task->Owner = $userId;
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
            
            return $task;
        }
    
        public function createTaskHistory($task, $feedback, $status)
        {
            $history = new History;
            $history->uuid = $task->uuid;
            $history->process_name  = 'Task';
            $history->created_by = $task->Owner;
            $history->feedback = $feedback;
            $history->status = $status;
            $history->p_id = isset($task->p_id) ? $task->p_id : null;
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
