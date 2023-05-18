<?php

namespace App\Services;
use App\Models\Account;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AccountService {
   

    public function insertData($data)
    {
        $userId = Auth::User()->id; 
        $account = new Account();
        $account->uuid = $uuid = mt_rand(10000000, 99999999);
        $account->Owner = $userId;
        $account->AccountName = $data['AccountName'];
        $account->AccountSite = $data['AccountSite'] ?? null;
        $account->ParentAccount = $data['ParentAccount']?? null;
        $account->AccountNumber = $data['AccountNumber']?? null;
        $account->AccountType = $data['AccountType']?? null;
        $account->Industry = $data['Industry']?? null;
        $account->AnnualRevenue = $data['AnnualRevenue']?? null;
       // $account->Rating = $data['Rating']?? null;
        $account->phone = $data['phone']  ?? null;
        $account->Fax = $data['Fax'] ?? null;
        $account->Website = $data['Website'] ?? null;
        $account->TickerSymbol = $data['TickerSymbol'] ?? null;
       // $account->Ownership = $data['Ownership']?? null;
        $account->Employees = $data['Employees'] ?? null;
        $account->SICCode = $data['SICCode'] ?? null;
        $account->BillingStreet = $data['BillingStreet'] ?? null;
        $account->BillingCity = $data['BillingCity'] ?? null;
        $account->BillingState = $data['BillingState'] ?? null;
        $account->BillingCode = $data['BillingCode'] ?? null;
        $account->BillingCountry = $data['BillingCountry'] ?? null;
        $account->ShippingStreet = $data['ShippingStreet'] ?? null;
        $account->ShippingCity = $data['ShippingCity'] ?? null;
        $account->ShippingState = $data['ShippingState'] ?? null;
        $account->ShippingCode = $data['ShippingCode'] ?? null;
        $account->ShippingCountry = $data['ShippingCountry'] ?? null;
        $account->Description = $data['Description'] ?? null;
        $account->save();
        Log::channel('create_account')->info('A new lead has been created. lead data: '.$account);
        return $account;
    }

    public function createHistory($account, $feedback, $status)
    {
        $history = new History;
        $history->uuid = $account->uuid;
        $history->process_name  = 'accounts';
        $history->created_by = $account->Owner;
        $history->feedback = $feedback;
        $history->status = $status;
        $history->save();
        $history->save();
    }
    public function getdata($authorizedRoleId)
    {
        $userRole = auth()->user()->role_id;
        //print_r($userRole);exit;
        $tableName = 'accounts';
        $columns = ['id', 'Owner', 'AccountName', 'phone'];

        if ($userRole == $authorizedRoleId) {
            $query = DB::table($tableName)
                    ->where('Owner', auth()->user()->id)
                    ->select($columns)
                    ->latest()
                    ->paginate(10);
        } else {
            $errorMessage = "You are not authorized to access this data.";
            return response()->json(['message' => $errorMessage], 403);
        }

        return $query;
    }

    public function updateAccount(Request $request, $uuid)
    {
        $account = Account::where('uuid', $uuid)->first();
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $originalData = clone $account;

        $account->update($request->all());

        $changes = $account->getChanges();

        if (empty($changes)) {
            return response()->json(['message' => 'No changes detected'], 400);
        }
        $column = key($changes);
        $before = $originalData->$column;
        $after = $changes[$column];
        $feedback = "$column was updated from $before to $after";

        $history = new History;
        $history->uuid = $uuid;
        $history->process_name = 'Account';
        $history->created_by = Auth::user()->uname;
        $history->feedback = $feedback;
        $history->status = 'Updated';
        
        $history->save();
    
        return response()->json(['message' => 'Account has been updated'], 200);
    }

    public function destroyAccount($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $account->delete();

        return response()->json(['message' => 'Account deleted'], 200);
    }

}