<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;        
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
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
    public function addCompany(Request $request)
    {
        // $userId = Auth::uname();
        $userId = Auth::User()->uname;

        print_r($userId);exit;
        //echo "addcomany"; die;
        $rules = [
            'cname' => 'required',
            'cemail' => 'required|email|unique:companies,cemail',
            'ctax_number' => 'required',
            'cphone' => 'required|integer',
            'ccity' => 'required|string',
            'cbilling_address' => 'required',
            'ccountry' => 'required',
            'cpostal_code' => 'required',
            'cemployees_size' => 'nullable|integer',
            'cfax' => 'nullable|string',
            'cdescription' => 'nullable|string',
            'domain_name' => 'required|unique:companies,domain_name',
            'cis_active' => 'required|boolean',
            'client_id' => 'required|integer',
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            $company = new Company;
            
            $company->cname = $request->cname;
            $company->cemail = $request->cemail;
            $company->ctax_number = $request->ctax_number;
            $company->cphone = $request->cphone;
            $company->ccity = $request->ccity;
            $company->cbilling_address = $request->cbilling_address;
            $company->ccountry = $request->ccountry;
            $company->cpostal_code = $request->cpostal_code;
            $company->cemployees_size = $request->cemployees_size;
            $company->cfax = $request->cfax;
            $company->cdescription = $request->cdescription;
            $company->domain_name = $request->domain_name;
            $company->cis_active = $request->cis_active;
            $company->client_id = $request->client_id;
            $company->user_id = $userId;
            $company->save();

            return response()->json(['message' => 'Company Added successfully'], 201);

    }

    /**
     * Display the specified resource.chlao isko route banale
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function showCompany(Company $company)
    {
        
        $userId = Auth::id();

        // $data = DB::table('users')
        // ->join('create_leads','users.id','=','create_leads.user_id')
        // ->select('users.uname','users.urole','create_leads.*')
        // ->where('users.id',$userId)->get();

        // echo "<pre>";
        // print_r($data);exit;

        //print_r($userId); die;
        $data = DB::table('users')
        ->select('users.id',  'companies.*')
        //->join('clients', 'users.id', '=', 'clients.user_id')
        ->join('companies', 'users.id', '=', 'companies.user_id')
        ->where('users.id', $userId)
        ->limit(7)
        ->orderBy('created_at', 'desc')
        ->get();
        
        return response()->json(['data' => $data], 201);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
