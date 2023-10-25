<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Services\DealService;
use App\Models\CreateLead;
use App\Helpers\TableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateDealRequest;

class DealController extends Controller
{
   // private $DealService; 

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

  
    public function storeDeal(CreateDealRequest $request, DealService $dealService)
    {
        $data = $request->validated();
        $deals = $this->dealService->addDeal($data);
        $p_id=$data['p_id'];
        $dealService->createHistory($deals, 'Deal Created', 'Add',$p_id);

        return response()->json([
            'deals' => $deals,
           'message' => 'Deal has been created',
        ], 201);
        
    

    }

   
    // public function showDealList(Deal $deal)
    // {
    //    // print_r($deal);exit;
    //    $userId = auth()->id();
    //    $deals = Deal::where('user_id', $userId)
    //                   ->orderBy('id', 'desc')
    //                   ->take(10)
    //                   ->get();
                   
    //     return response([
    //         'deals'=>$deals,
    //         'status'=>'success'
    //     ], 200);
    // }
  
    public function showDealList(Request $request)
    {
        $deals = TableHelper::getTableData('deals', ['*']);

        foreach ($deals as $key => $value) {
            $p_id = $value->p_id;
            $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
            $deals[$key]->related = $relatedData;
        }

        return response(['deals' =>$deals,'status'=>'success'], 200);
    }

    public function showSingleDeal($uuid)
    {
       $deals = AllInOneController::singledata('deals','*','uuid',$uuid);

       foreach ($deals as $key => $value) {
        $p_id = $value->p_id;
        $relatedData = AllInOneController::singledata('create_leads', ['lead_Name', 'phone','email'], 'uuid', $p_id);
        $deals[$key]->leads = $relatedData;
    }
        return response([
            'deals'=>$deals,
            'status'=>'success'
        ], 200);

    }

    // public function updateDeal(Request $request, DealService $dealService ,$id)
    // {
    //     $deal = Deal::find($id);
    //     if (!$deal) {
    //         return response()->json(['message' => 'Deal not found']);
    //     }

    //     $deal->update($request->all());
    //       return response()->json(['message' => 'Deal update successfully']);
    // }

    public function updateDeals(Request $request, $uuid)
    {
        
        return $this->dealService->updateDeals($request, $uuid);
    }


    public function deleteDeal($id)
    {
        $deals = Deal::find($id);

        if (!$deals) {
            return response()->json(['message' => 'Deal not found'], 404);
        }

        $deals->delete();

        return response()->json(['message' => 'Deal deleted'], 200);
    }
}
