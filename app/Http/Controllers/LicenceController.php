<?php

namespace App\Http\Controllers;

use App\Models\Licence;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
class LicenceController extends Controller
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
    public function createLience(Request $request)
    {
        $uuid = mt_rand(10000000, 99999999);
        //$user_id = Auth::user()->id;
        $data = $request->all();
        $data['uuid'] = $uuid;
    
        // Retrieve the company ID from the Company table
        $companyRecord = Company::latest('created_at')->first(); // Retrieve the latest company record
        $cid = $companyRecord->id; // Retrieve the company ID from the latest company record
        
        $data['company_id'] = $cid; // Assign the company ID to the 'company_id' field
    
        //$data['user_id'] = $user_id;
        $model = Licence::class;
        CommonHelper::saveDatam($model, $data);
    
        return response(['data' => $data, 'status' => 'success'], 201);
    }
    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Licence $licence)
    {
        //
    }

    
    public function edit(Licence $licence)
    {
        //
    }

    
    public function update(Request $request, Licence $licence)
    {
        //
    }

    
    public function destroy(Licence $licence)
    {
        //
    }
}
