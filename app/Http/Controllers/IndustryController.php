<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Industry;
use App\Helpers\CommonHelper;
use App\Helpers\TableHelper;

class IndustryController extends Controller
{
    public function createIndustry(Request $request)
    {
        $request->validate([
            'company_id' => 'nullable',
            'industry_name' => 'required',

        ]);

        $company_id = auth()->user()->company_id;

        $data = $request->only(['industry_name']);
        $data['company_id'] = $company_id;

        $model = Industry::class;

        CommonHelper::saveDatam($model, $data);

        return response(['data' =>$data,'status'=>'success'], 200);
    }

    public function showIndustry()
    {
        $industries = TableHelper::getTableData('industries', ['*']);
        return response(['industries' =>$industries,'status'=>'success'], 200);
    }
}
