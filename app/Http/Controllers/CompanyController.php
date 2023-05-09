<?php

namespace App\Http\Controllers;

use App\Rules\UniqueDomain;
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
use App\Http\Requests\CreateCompanyRequest;

class CompanyController extends Controller
{


    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    public function addCompany(CreateCompanyRequest $request,CompanyService $companyService)
    {
        $data = $request->validated();  
        $company = $this->companyService->insertData($data);
        return response(['message' => 'Company created Successfully','status'=>'success','company' => $company], 200);     
    }
    
    public function showCompany(Request $request)
    {
        
        // $data_list = AllInOneController::tabledetails_col("companies","*");
        // return response()->json(['data_list' => $data_list], 201);
        
        $getCompanies = DataFetcher::getCompanies(['*'], $request->input('perPage', 10));
        return response(['getCompanies' =>$getCompanies,'status'=>'success'], 200);
    }

  
    public function updateCompany(Request $request, Company $company ,$id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found']);
        }

        $company->update($request->all());
        
        return response()->json(['message' => 'Company updated successfully']);
    }

   
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
