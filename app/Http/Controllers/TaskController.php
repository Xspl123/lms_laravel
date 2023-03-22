<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\AllInOneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSingleTask()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request)
    {
        $TaskOwner = Auth::user()->uname;
        //print_r($TaskOwner); die;
        $userId = Auth::id();
       // print_r($userId); die;
        $rules = [
            'Subject' => 'required',
            'DueDate' => 'required',
            'Status' => 'required',
            'Priority' => 'required',
            'Reminder' => 'required',
            'Repeat' => 'required',
            'Description' => 'required',
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            $task = new Task;

            $task->TaskOwne = $TaskOwner;
            $task->Subject = $request->Subject;
            $task->DueDate = $request->DueDate;
            $task->Status = $request->Status;
            $task->Priority = $request->Priority;
            $task->Reminder = $request->Reminder;
            $task->Repeat = $request->Repeat;
            $task->Description = $request->Description;
            $task->user_id = $userId;
            $task->save();
            return response()->json(['message' => 'Task Added successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showTaskList()
    {
  
       $data_list = AllInOneController::tabledetails_col("tasks","Subject,Status");
            return response([
            'task'=>$data_list,
            'status'=>'success'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request ,$id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($request->all());

        return response()->json(['message' => 'Task updated', 'task' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
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
