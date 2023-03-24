<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AllInOneController;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Helpers\DataFetcher;
use App\Helpers\CommonHelper;
use App\Helpers\ApiHelperSearchData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;  

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
            'job' => 'required'
        ]);

        $data = $request->only(['full_name', 'phone', 'email','job', 'note','client_id','is_active','user_id']);
        $model = Employee::class;
        CommonHelper::saveDatam($model, $data);

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
    public function update(Request $request, Employee $employee)
    {
        //
    }

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
