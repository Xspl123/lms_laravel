<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\History;
use App\Services\TaskService;
use App\Http\Controllers\AllInOneController;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateTaskRequest;
use App\Helpers\TableHelper;

use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    

    private $taskService;

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

    
    public function createTask(CreateTaskRequest $request, TaskService $taskService)
    {
        $data = $request->validated();

        $task = $taskService->createTask($data);

        $p_id = $data['p_id'];
    
        $taskService->createTaskHistory($task, 'Task Created', 'Add', $p_id);

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
        ]);
    }

  
    public function showTaskList()
    {
  
    //    $data_list = AllInOneController::tabledetails_col("tasks","Subject,Status");
    //         return response([
    //         'task'=>$data_list,
    //         'status'=>'success'
    //     ], 200);

    $data_list = TableHelper::getTableData('tasks', ['*']);

    foreach ($data_list as $key => $value) {
        $p_id = $value->p_id;
        $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
        $data_list[$key]->related = $relatedData;
    }

    return response(['data_list' =>$data_list,'status'=>'success'], 200);
    }

   
    public function showSingTasks($uuid)
    {   
       
       $singelTask = AllInOneController::singledata('tasks','*','uuid',
       $uuid);
       
       foreach ($singelTask as $key => $value) {
        $p_id = $value->p_id;
        $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
        $singelTask[$key]->leads = $relatedData;
    }

        return response([
            'singelTask'=>$singelTask,
            'status'=>'success'
        ], 200);

    }

    public function updateTask(Request $request ,$uuid)
    {
        $username = Auth::user()->uname;
        $task = Task::where('uuid', $uuid)->first();
        

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $originalData = clone $task;
        //print_r($originalData);exit;
        $task->update($request->all());
        
        $changes = $task->getChanges();
        
        //print_r($changes);exit;
         $coloumname='';
         $after_data='';
         $beforedate='';
         $coloumnamekey= array_key_first($changes);
        // print_r($coloumnamekey);exit;
        foreach($changes as $key=>$value) {
            if($key == $coloumnamekey) {
                $coloumname=$value;
                $coloumname=$key;
                $after_data=$originalData[$key];
                $after_data ? $after_data : $after_data='Null Values'; 
                $beforedate= $value;
                $feadback= $coloumname.' was updated from '.$after_data.'  to '.$beforedate;
                $history = new History;
                $history->uuid = $uuid;
                $history->process_name  = 'tasks';
                $history->created_by = $username;
                $history->feedback = $feadback;
                $history->status = 'Updated';
                $history->save();
                Log::channel('update_task')->info('Task has been updated. task data: '.$feadback);

                return response()->json(['message' => 'Task has been updated'], 200);
            }
             
        }
         return response()->json(['message' => ' Task has been not updated'], 200);

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

    public function search(Request $request)
    {
        $table = 'tasks'; // Replace with your actual table name
        $searchTerm = $request->input('search_term');
    
        // Call the search function from the helper class
        $results = ApiHelperSearchData::searchOwner($table, $searchTerm);
    
        // Check if any results were found
        if ($results->count() > 0) {
            return response()->json(['message' => 'Search results found', 'results' => $results]);
        } else {
            return response()->json(['message' => 'No results found', 'results' => []]);
        }
    }
    
}
