<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;    
 
use Illuminate\Support\Arr;

class AllInOneController extends Controller
{
    public function tabledetails($tabel){
       
        $user = DB::table($tabel)->select('MAIL_DRIVER','MAIL_HOST','MAIL_FROM_ADDRESS','MAIL_FROM_NAME','MAIL_USERNAME')
        ->orderBy('id','ASC')
        ->get();
        return $user;
    }

    public function tabledetails_col($table,$col,$order=''){

        $column=explode(',',$col);
        $data = DB::table($table)->select($column)
        ->orderBy('id','ASC')
        ->get();
        return $data;
    }

    public function singledata($table,$column,$scloumn,$dcloumn)
    {
        $leads = DB::table($table)->select($column)->where($scloumn,$dcloumn)->latest()->get();
        if (!$leads) {
            return response()->json([
                'success' => false,
                'message' => 'leads not found'
            ], 404);
        }
            else {

                return $leads;
            
            }
    }
    public function singledataOR($table,$column,$scloumn,$dcloumn)
    {
        $leads = DB::table($table)->select($column)->where($scloumn,$dcloumn)->orWhere('p_id',$dcloumn)->orderBy('id', 'DESC')->get();
        if (!$leads) {
            return response()->json([
                'success' => false,
                'message' => 'leads not found'
            ], 404);
        }
            else {

                return $leads;
            
            }
    }

    public function alluserdata_campany()
    {
        return ['foo', 'bar', 'baz'];
    }

    public function role(){

        $role = DB::table('roles')->select('id','name')->get();
    }

    
    //public function getTableData($tableName, $columns = ['*'])
    //{

    //     $roleId = auth()->user()->role_id;
    //     $company_id = auth()->user()->company_id;
    //     $data = DB::table($tableName)->select($columns)->where('role_id',$roleId)->get();

    //     $role= new RoleController;
    //     $getRole = $role->getRolesHierarchy();
        
    //     $role_name = $getRole->original['Role_name'];
    //     //$data = $this->alluserdata_campany();
    //     $data = DB::table('users')
    //     ->select('id')
    //     ->where('company_id', $company_id)
    //     ->whereIn('urole', ['CEO'])
    //     ->get();
    //   // print_r($data);exit;
    //    $id = ''; 
    
    // foreach ($data as $item) {
    //     if ($item->id == $id) {
    //         // id found
            
    //         break; // exit the loop
    //     }
    //     print_r ($item);exit;

        // $data = DB::table($tableName)->select($columns)->latest()->paginate(10);
        // return $data;
    
    
    //if the loop completes without finding the id, it is not present in the $data collection
   // $data = DB::table($tableName)->select($columns)->whereIn('lead_Owner',$data)->latest()->paginate(10);

        
    //}

    public static function getTableData($tableName, $columns = ['*'], $conditions = [], $perPage = 10)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return [];
        }

        $user = Auth::user();

        // Add the condition to fetch data only for the logged-in user
        $conditions['user_id'] = $user->id;

        // Fetch paginated data based on the modified conditions
        $data = DB::table($tableName)
            ->select($columns)
            ->where($conditions)
            ->latest()
            ->paginate($perPage);

        return $data;
    }
}


