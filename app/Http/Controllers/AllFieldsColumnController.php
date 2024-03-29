<?php

namespace App\Http\Controllers;

use App\Models\AllFieldsColumn;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AllFieldsColumnController extends Controller
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
    public function Createallfieldcolumns(Request $request)
    {
        // $userId = Auth::uname();
        //$username = Auth::User()->uname;   
        //$userId = Auth::User()->id; 
        //echo "addcomany"; die;
        //$uuid = Str::uuid();
        //$uuid = mt_rand(10000000, 99999999);
        // $hexString = dechex($randomNumber);
        // $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $hexString)->toString();
         //print_r($uuid);exit;
        $rules = [
            'processName' => 'required',
            'fieldsName' => 'required',
            'Column_Name' => 'required',
           
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            $allFieldsColumn = new AllFieldsColumn;

            $allFieldsColumn->processName = $request->processName;
            $allFieldsColumn->fieldsName = $request->fieldsName;
            $allFieldsColumn->Column_Name = $request->Column_Name;
            $allFieldsColumn->save();

            return response()->json(['message' => 'AllFieldsColumn Added successfully','allFieldsColumn' => $allFieldsColumn], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AllFieldsColumn  $allFieldsColumn
     * @return \Illuminate\Http\Response
     */
    public function showallfieldcolumns(Request $request,AllFieldsColumn $allFieldsColumn)
    {
        
        $show_fields = DB::table('all_fields_columns')
        ->select('*')
        ->where('processName',$request->processName)
        ->get();
        return response()->json(['message' => 'List of AllFieldsColumn','show_fields' => $show_fields], 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AllFieldsColumn  $allFieldsColumn
     * @return \Illuminate\Http\Response
     */
    public function edit(AllFieldsColumn $allFieldsColumn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AllFieldsColumn  $allFieldsColumn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllFieldsColumn $allFieldsColumn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AllFieldsColumn  $allFieldsColumn
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllFieldsColumn $allFieldsColumn)
    {
        //
    }
}
