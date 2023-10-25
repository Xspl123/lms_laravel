<?php


namespace App\Services;

use App\Models\Deal;
use App\Models\User;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DealService{

    public function getDeal(int $id){
        return Deal::find($id);
    }

    public function getDeals(){
        return Deal::all();
    }

    public function addDeal(array $data):Deal
    {
        $deals = new Deal();
        $deals->uuid = mt_rand(10000000, 99999999);
        $deals->p_id =  $data['p_id'] ?? null;
        $deals->Owner =  Auth::User()->uname;
        $deals->dealName = $data['dealName'];
        $deals->accountName = $data['accountName'];
        $deals->type = $data['type'] ?? null;
        $deals->amount = $data['amount'];
        $deals->closingDate = $data['closingDate'];
        $deals->stage = $data['stage'];
        $deals->probability = $data['probability'];
        $deals->expectedRevenue = $data['expectedRevenue'];
        $deals->campaignSource = $data['campaignSource'];
        $deals->description = $data['description'] ?? null;
        $deals->user_id = Auth::User()->id;
        $deals->owner_id = Auth::User()->id;
        $deals->save();
        Log::channel('create_deal')->info('A new Deal has been created. Deal data: '.$deals);
        return $deals;
    }

    public function createHistory($deals, $feedback, $status)
    {
        $history = new History;
        $history->uuid = $deals->uuid;
        $history->process_name  = 'Deal';
        $history->created_by = $deals->Owner;
        $history->feedback = $feedback;
        $history->status = $status;
        $history->save();
        
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
    
    public function updateDeals(Request $request, $uuid)
    {
        $deals = Deal::where('uuid', $uuid)->first();
        
        if (!$deals) {
            return response()->json(['message' => 'Deals not found'], 404);
        }

        $originalData = clone $deals;

        $deals->update($request->all());

        $changes = $deals->getChanges();

        if (empty($changes)) {
            return response()->json(['message' => 'No changes detected'], 400);
        }
        $column = key($changes);
        $before = $originalData->$column;
        $after = $changes[$column];
        $feedback = "$column was updated from $before to $after";

        $history = new History;
        $history->uuid = $uuid;
        $history->process_name = 'Deal';
        $history->created_by = Auth::user()->uname;
        $history->feedback = $feedback;
        $history->status = 'Updated';
        $history->save();
        return response()->json(['message' => 'Deal has been updated','data'=>$deals], 200);
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