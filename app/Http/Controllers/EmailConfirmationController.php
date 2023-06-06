<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email_Confirmation;
use App\Helpers\CommonHelper;

class EmailConfirmationController extends Controller
{
    public function getEmailConfirmationDetails()
    {
        $data_list = AllInOneController::tabledetails('email__confirmations');
        return response(['data_list' =>$data_list,'status'=>'success'], 200);
    }

    public function sendEmailConfirmation(Request $request)
    {
        $data = $request->all();
        $model = Email_Confirmation::class;
        CommonHelper::saveDatam($model, $data);
        return response(['data' =>$data,'status'=>'success'], 201);
    }
}
