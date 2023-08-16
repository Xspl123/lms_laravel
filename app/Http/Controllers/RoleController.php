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
    private $roles_name;

    public function index()
    {
       
    }

   
    public function createRole(Request $request )
    {
        $userId = Auth::id();
        $compId = Company::latest()->value('id');
        //print_r($compId);exit;
        $rules = [
            'role_name' => 'required|unique:roles,role_name',
            'company_id' => 'nullable',
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
        // ->join('companies', 'roles.company_id', '=', 'companies.id')
         ->select('roles.*')
         //->where('company_id','12')
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
        $id = auth()->user()->id;
        $roleId = auth()->user()->role_id;
        $roles = DB::table('roles')
                    ->select('id', 'role_name', 'p_id','company_id')
                    ->where('id', $roleId)
                    ->orWhere('company_id', $campany_id)
                    ->get(); // Get all roles with p_id 0 (i.e. CEO)

         $rolesWithChildRoles = $this->getChildRoles($roles);

          
        // print_r($rolesWithChildRoles);  //Outputs the reduced aray
          return $rolesWithChildRoles;
    }
    
    public function getChildRoles($roles) {
          
        foreach($roles as $role) {
       
            $childRoles = DB::table('roles')
                            ->where('p_id', $role->id)
                            ->get(); // Get all child roles for current role
               
            if($childRoles->count() > 0) {
                $role->childRoles = $childRoles;
                $this->getChildRoles($childRoles);
                $roles_name= $this->showroles($role->role_name);
            }else{
                $roles_name= $this->showroles($role->role_name);
            }
        }

        return response()->json(['roles' => $roles]); 
       
        }

        public function showroles($roles){
            
               $this->roles_name[] = $roles;
              
               return $this->roles_name;
        }

}
