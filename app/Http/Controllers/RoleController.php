<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    
    public function index()
    {
        //
    }

   
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

   
    public function store(Request $request)
    {
        //
    }

   
    public function showRole(Role $role)
    {
    
       $role_company = DB::table('roles')
        ->join('companies', 'roles.company_id', '=', 'companies.id')
         ->select('roles.*', 'companies.cname')
        ->get();
        //print_r($role_company);
        return response()->json(['role_company' => $role_company], 201);

    }

   
    public function edit(Role $role)
    {
        //
    }

   
    public function update(Request $request, Role $role)
    {
        //
    }

  
    public function destroy(Role $role)
    {
        //
    }
}
