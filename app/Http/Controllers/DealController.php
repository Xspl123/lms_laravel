<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Services\DealService;
use App\Models\CreateLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
      
    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

  
    public function storeDeal(Request $request, DealService $dealService)
    {
        $validatedData = $request->validate([
            'dealName' => 'required',
            'accountName' => 'required',
            'type' => 'nullable',
            'amount' => 'required',
            'closingDate' => 'required',
            'stage' => 'required',
            'probability' => 'required',
            'expectedRevenue' => 'required',
            'campaignSource' => 'required',
            'description' => 'nullable',
        ]);
        $deals = $this->dealService->addDeal($validatedData);

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
        $userId = Auth::id();
        $deals = Deal::join('users', 'deals.user_id', '=', 'users.id')
                   ->select('deals.*')
                   ->where('users.id', $userId)
                   ->limit(10)
                   ->orderBy('id', 'desc')
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
