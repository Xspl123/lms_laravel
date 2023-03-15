<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRole(Request $request )
    {
        
       
            // $role_company = DB::table('roles')
            // ->select('*')
            // ->join('companies','roles.id','=','companies.id')
            // ->where('companies.id','=', $roles_id)
            // ->get();

            // return $role_company;exit; 

        $rules = [
            'role_name' => 'required|unique:roles,role_name',
            
           
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            
            $role = new Role;

            $role->p_id = $request->p_id;
            $role->company_id = $request->company_id;
            $role->role_name = $request->role_name;

            $role->save();

            return response()->json(['message' => 'Role Added successfully','role' => $role], 201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function showRole(Role $role)
    {
    
       $role_company = DB::table('roles')
        ->join('companies', 'roles.company_id', '=', 'companies.id')
         ->select('roles.id', 'roles.p_id', 'companies.cname')
        ->get();
        //print_r($role_company);
        return response()->json(['role_company' => $role_company], 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
