<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AllInOneController extends Controller
{
    public function tabledetails($tabel){
       
        $user = DB::table($tabel)->select('*')->get();
        return $user;
    }

    public function tabledetails_col($table,$col){

            $column=explode(',',$col);
           
       
        $data = DB::table($table)->select($column)->get();
        return $data;
    }


}
