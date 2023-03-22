<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AllInOneController extends Controller
{
    public function tabledetails($tabel){
       
        $user = DB::table($tabel)->select('*')
        ->orderBy('id','ASC')
        ->get();
        return $user;
    }

    public function tabledetails_col($table,$col,$order=''){

            $column=explode(',',$col);
           
       
        $data = DB::table($table)->select($column)
        ->orderBy('id','ASC')
        ->paginate(3, ['*'], 'pageName');
        return $data;
    }

    public function singlelead($table,$column,$scloumn,$dcloumn)
    {
        $leads = DB::table($table)->select($column)->where($scloumn,$dcloumn)->get();
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


}