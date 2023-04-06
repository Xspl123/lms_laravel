<?php


namespace App\Services;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DealService{

    public function getDeal(int $id){
        return Deal::find($id);
    }
    public function getDeals(){
        return Deal::all();
    }
    public function addDeal($data){
      
        $deals = new Deal();
        $deals->dealOwner = Auth::User()->uname;
        $deals->dealName = $data['dealName'];
        $deals->accountName = $data['accountName'];
        $deals->type = $data['type'] ?? null;
        $deals->amount = $data['amount'];
        $deals->leadOwner = Auth::user()->uname;
        $deals->closingDate = $data['closingDate'];
        $deals->stage = $data['stage'];
        $deals->probability = $data['probability'];
        $deals->expectedRevenue = $data['expectedRevenue'];
        $deals->campaignSource = $data['campaignSource'];
        $deals->description = $data['description'] ?? null;
        $deals->user_id = Auth::User()->id;
        $deals->save();
        return $deals;
    }
    
    public function updateDeal($id, $data){
        $data = Deal::where('id',$id)->first()->update($request->all());
        $deals->update($data);
        return $deals;
    }
    public function updateUser(array $data, $id)
    {
        $user = Deal::where('id', $id)->firstOrFail();
        $deals->dealOwner = Auth::User()->uname;
        $deals->dealName = $data['dealName'];
        $deals->accountName = $data['accountName'];
        $deals->type = $data['type'] ?? null;
        $deals->amount = $data['amount'];
        $deals->leadOwner = Auth::user()->uname;
        $deals->closingDate = $data['closingDate'];
        $deals->stage = $data['stage'];
        $deals->probability = $data['probability'];
        $deals->expectedRevenue = $data['expectedRevenue'];
        $deals->campaignSource = $data['campaignSource'];
        $deals->description = $data['description'] ?? null;
        $deals->user_id = Auth::User()->id;
        $deals->save();
        
        return $deals;
    }
    



    public function deleteDeal(int $id){
        $deal = Deal::find($id);
        return $deal->delete();
    }
    public function addUser(int $userId){
        $user = new User();
        $user->user_id = $userId;
        return $user->save();
    }
    
    public function deleteUser(int $id){
        $user = User::find($id);
        return $user->delete();
    }
    public function getUsers(){
        return User::all();
    }
    public function addUserToDeal(int $dealId, int $userId){
        $user = User::find($userId);
        $deal = Deal::find($dealId);
        $user->deal_id = $deal->id;
        return $user->save();
    }
    public function addDealToUser(int $userId, int $dealId){
        $user = User::find($userId);
        $deal = Deal::find($dealId);
        $user->deal_id = $deal->id;
        return $user->save();
    }    
         
}