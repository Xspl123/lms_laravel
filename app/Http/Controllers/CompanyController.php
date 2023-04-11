<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use App\Helpers\DataFetcher;        
use Illuminate\Http\Request;
use App\Services\CompanyService;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{


    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }



    public function index()
    {
        //
    }

  
    public function create()
    {
        //
    }

    public function addCompany(Request $request,CompanyService $companyService)
    {
            $validatedData = $request->validate([
                'cname' => 'required',
                'company' => 'required',
                'cemail' => 'required',
                'cphone'=>[
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\d{10}$/', $value)) {
                            $fail('The phone must be exactly 10 digits.');
                        }
                    },
                ],
                'ccity' => 'required|string',
                'ccountry' => 'required',
                'domain_name' => 'required|unique:companies,domain_name',
                'cis_active' => 'required'
            ]);
               
            $company = $this->companyService->insertData($validatedData);
            return response(['message' => 'Company created Successfully','status'=>'success','company' => $company], 200);
    }
    
        

        
    
    /**
     * Display the specified resource.chlao isko route banale
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function showCompany(Request $request)
    {
        
        // $data_list = AllInOneController::tabledetails_col("companies","*");
        // return response()->json(['data_list' => $data_list], 201);
        
        $getCompanies = DataFetcher::getCompanies(['*'], $request->input('perPage', 10));
        return response(['getCompanies' =>$getCompanies,'status'=>'success'], 200);
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
    public function updateCompany(Request $request, Company $company ,$id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found']);
        }

        $company->update($request->all());
        
        return response()->json(['message' => 'Company updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function deleteCompany(Company $company , $id)
    {
       //echo "delete product";
       $company = Company::find($id);
       //print_r($id);
       if (!$company) {
        return response()->json(['message' => 'Company not found'], 404);
       }
       $company->delete();
       return response()->json (['message' => 'Company deleted successfully']);
    }
}
