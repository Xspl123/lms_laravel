<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\CreateLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
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
    public function storeDeal(Request $request)
    {
       
        $deal_Owner = Auth::user()->uname;
        $userId = Auth::id();
        $rules = [
            'dealName' => 'required',
            'accountName' => 'required',
            'amount' => 'required',
            'closingDate' => 'required',
            'stage' => 'required',
            'probability' => 'required',
            'expectedRevenue' => 'required',
            'campaignSource' => 'required',
            'description' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $deals = Deal::updateOrCreate([
            'dealOwner' => $deal_Owner,
            'dealName' => $request->dealName,
            'accountName' => $request->accountName,
            'type' =>$request->type,
            'amount' => $request->amount,
            'leadOwner' => $deal_Owner,
            'closingDate' => $request->closingDate,
            'stage' => $request->stage,
            'probability' => $request->probability,
            'expectedRevenue' => $request->expectedRevenue,
            'campaignSource'=> $request->campaignSource,
            'description'=> $request->description,
            'user_id' => $userId

        ]);
         
        return response([
            'message' => 'Lead created Successfully',
            'status'=>'success'
        ], 200);


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
    public function updateDeal(Request $request, Deal $deal ,$id)
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
