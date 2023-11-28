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
use App\Helpers\ApiHelperSearchData;

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

    public function updateDeals(CreateDealRequest $request, DealService $dealService ,$uuid)
    {
        return $this->dealService->updateDeals($request, $uuid);
        return response()->json([
            'message' => 'Deal update successfully'
        ]);

    }

    public function destroyDeal($uuid)
    {
        return $this->dealService->deleteDeal($uuid);
    }

    public function deleteAllDeals()
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Delete only the leads belonging to the authenticated user
        Deal::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Your deals deleted successfully'], 200);
    }


    public function searchDeal(Request $request)
    {
        $searchTerm = $request->input('search_term');

        // Check if the search term is valid
        if (empty($searchTerm)) {
            return response()->json(['message' => 'Invalid search term'], 400);
        }
        
        $data_list = ApiHelperSearchData::search('deals', $searchTerm);
        
        if ($data_list->total() > 0) 
        {
            foreach ($data_list as $key => $value) {
                $uuid = $value->uuid;
                $Owner = $value->Owner;
        
                $relatedData = AllInOneController::singledata('meetings', ['title', 'from', 'to'], 'p_id', $uuid);
        
                $data_list[$key]->related_activities = $relatedData;
                $data_list[$key]->number_of_meetting = $relatedData->count();

                $owner_list = AllInOneController::singledata('users', ['uname','urole','email'], 'id', $Owner);
                $data_list[$key]->Owner = $owner_list;
            }
        
            // Rows found, do something with the data
            return response()->json(['message' => 'Deal found', 'Deal' => $data_list], 200);
        } 
        else 
        {
            // No leads found
            return response()->json(['message' => 'No Deal found'], 404);
        } 
    }


}
