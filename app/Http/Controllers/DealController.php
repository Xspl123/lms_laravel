<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Services\DealService;
use App\Models\CreateLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateDealRequest;

class DealController extends Controller
{
      
    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

  
    public function storeDeal(CreateDealRequest $request, DealService $dealService)
    {
        $data = $request->validated();
        $deals = $this->dealService->addDeal($data);
        $dealService->createHistory($deals, 'Deal Created', 'Add');

        return response()->json([
            'deals' => $deals,
           'message' => 'Deal has been created',
        ], 201);
        
    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function showDealList(Deal $deal)
    {
       // print_r($deal);exit;
       $userId = auth()->id();
       $deals = Deal::where('user_id', $userId)
                      ->orderBy('id', 'desc')
                      ->take(10)
                      ->get();
                   
        return response([
            'deals'=>$deals,
            'status'=>'success'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function edit(Deal $deal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function updateDeal(Request $request, DealService $dealService ,$id)
    {
        $deal = Deal::find($id);
        if (!$deal) {
            return response()->json(['message' => 'Deal not found']);
        }

        $deal->update($request->all());
          return response()->json(['message' => 'Deal update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
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
