<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use App\Http\Controllers\AllInOneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function showSingleTask()
    {
        //
    }

   
    public function create()
    {
        //
    }

    
    public function createTask(Request $request,TaskService $taskService)
    {
        $validatedData = $request->validate([
            'Subject' => 'required',
            'DueDate' => 'required',
            'Status'=> 'required',
            'Priority' => 'required',
            'Reminder' => 'required',
            'Repeat' => 'required',
            'Description' => 'required'
        ]);
        
        $task = $this->taskService->insertData($validatedData);
        return response(['message' => 'Task created Successfully','status'=>'success','task' => $task], 200);
    }

  
    public function showTaskList()
    {
  
       $data_list = AllInOneController::tabledetails_col("tasks","Subject,Status");
            return response([
            'task'=>$data_list,
            'status'=>'success'
        ], 200);
    }

   
    public function edit(Task $task)
    {
        //
    }

    public function updateTask(Request $request ,$id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($request->all());

        return response()->json(['message' => 'Task updated', 'task' => $task], 200);
    }

    public function deleteTask(Task $task, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted'], 200);
    }


    public function deleteAllTasks(Task $task)
    {
        $task = Task::truncate();

        return response()->json(['message' => 'All tasks deleted successfull'], 200);

    }
}
