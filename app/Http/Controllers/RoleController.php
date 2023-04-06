<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class RoleController extends Controller
{   


    public function index()
    {
       
    }

   
    public function createRole(Request $request )
    {
        $userId = Auth::id();
        $compId = Company::latest()->value('id');
        //print_r($compId);exit;
        $rules = [
            //'role_name' => 'required|unique:roles,role_name',
            'company_id' => 'required|unique:roles,company_id',
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            
            $role = new Role;

            $role->p_id = $request->p_id;
            $role->company_id = $compId;
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
         ->where('company_id','12')
        ->get();
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


    public function getRolesHierarchy() {
         
        $campany_id = auth()->user()->company_id;
        //print_r($campany_id);exit;
        $roles = DB::table('roles')
                    ->select('id', 'role_name', 'p_id','company_id')
                    ->where('id', $campany_id)
                    ->get(); // Get all roles with p_id 0 (i.e. CEO)

         $rolesWithChildRoles = $this->getChildRoles($roles);
         return $rolesWithChildRoles;
    }
    
    private function getChildRoles($roles) {
        
        foreach($roles as $role) {
       
            $childRoles = DB::table('roles')
                            ->where('p_id', $role->id)
                            ->get(); // Get all child roles for current role
               
            if($childRoles->count() > 0) {
                $role->childRoles = $childRoles;
                $this->getChildRoles($childRoles);
            }else{
               // print_r($rl);
            }
        }

        return response()->json(['roles' => $roles]); 
       
        }
}
