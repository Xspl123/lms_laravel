<?php

namespace App\Http\Controllers;
use App\Models\EmployeeHistory;
use App\Http\Controllers\AllInOneController;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Helpers\DataFetcher;
use App\Helpers\CommonHelper;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $employee = Employee::query();
            $employeeData = ApiHelperSearchData::search($employee, $request, 'employees', true);
            return response()->json([
                'employee' => $employeeData['results'],
                'employee_count' => $employeeData['total_count'],
            ]);
    
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
    public function storeEmployee(Request $request)
    { 
         $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{10}$/', $value)) {
                        $fail('The phone must be exactly 10 digits.');
                    }
                },
            ],
            'email' => 'required|email|unique:employees',
            'job' => 'required',
            'note' => 'nullable|string',
            'uuid' => 'nullable',
            'is_active'=> 'nullable',
            'user_id' => 'nullable'
        ]);
        
        $uuid = mt_rand(10000000, 99999999);
        $user_id = Auth::user()->id;

        $data = $request->only(['full_name', 'phone', 'email','job', 'note','uuid','client_id','is_active','user_id']);
        $data['uuid'] = $uuid;
        $data['user_id'] = $user_id;

        $model = Employee::class;

        CommonHelper::saveDatam($model, $data);

        // Log the insertion in the employee_history table

        DB::table('employee_history')->insert([
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'job' => $data['job'],
            'uuid' => $data['uuid'],
            'user_id' => $data['user_id'],
            'created_by' => Auth::user()->id,
            'feedback' => 'Inserted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        

        return response(['data' =>$data,'status'=>'success'], 200);
                
                
             
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request, Employee $employee,$id)
    {
           // Get the original record from the employees table
           $originalData = Employee::find($id)->get();

        // Update the $data array with the created_by and feedback values from the original record
            $data['created_by'] = $originalData['created_by'];
            $data['feedback'] = $originalData['feedback'];

        // Add the updated_by and feedback values to the $data array
            $data['updated_by'] = Auth::user()->id;
            $data['feedback'] = 'employee_updated';

        // Update the record in the employees table
            $model = Employee::class;
            CommonHelper::updateData($model, $data, $id);

        // Log the update in the employee_history table
            EmployeeHistory::create($data);
    }

    // public function updateEmployee(Request $request, $id)
    // {
    //     // $request->validate([
    //     //     'full_name' => 'required|string|max:255',
    //     //     'phone' => [
    //     //         'required',
    //     //         'string',
    //     //         function ($attribute, $value, $fail) {
    //     //             if (!preg_match('/^\d{10}$/', $value)) {
    //     //                 $fail('The phone must be exactly 10 digits.');
    //     //             }
    //     //         },
    //     //     ],
    //     //     'email' => 'required|email|unique:employees,email,'.$id,
    //     //     'job' => 'required',
    //     //     'note' => 'nullable|string',
    //     //     'uuid' => 'nullable',
    //     //     'is_active'=> 'nullable',
    //     //     'user_id' => 'nullable'
    //     // ]);
    
    //     $employee = Employee::findOrFail($id);
    
    //     $previousData = $employee->toArray();
    
    //     $data = $request->only(['full_name', 'phone', 'email', 'job', 'note', 'uuid', 'client_id', 'is_active', 'user_id']);
    
    //     $employee->update($data);
    
    //     $updatedData = $employee->toArray();
    
    //     // Log the history entry
    //     $history = new EmployeeHistory;
        
    //     $history->full_name = $data['full_name'];
    //     $history->phone = $data['phone'];
    //     $history->email = $data['email'];
    //     $history->job = $data['job'];
    //     $history->uuid = $data['uuid'] ?? '';
    //     $history->client_id = $data['client_id'] ?? null;
    //     $history->is_active = $data['is_active'] ?? true;
    //     $history->user_id = $data['user_id'] ?? null;
    //     $history->created_by = Auth::id();
    //     $history->update_by = Auth::id();
    //     $history->feedback = "Employee updated by ". $employee->full_name ." on " . now()->format('Y-m-d H:i:s');
    //     $history->previous_data = json_encode($previousData);
    //     $history->updated_data = json_encode($updatedData);
    //     $history->save();
    
    //     return response()->json(['message' => 'Employee updated successfully'], 200);
    
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function getemp(Request $request)
    {
        $getemp = DataFetcher::getEmp(['*'], $request->input('perPage', 10));
        return response(['getemp' =>$getemp,'status'=>'success'], 200);
    }
}
