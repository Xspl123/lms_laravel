<?php

namespace App\Services;
use App\Models\Account;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        public function getdata()
            {
                $userRole = auth()->user()->role_id;
                $authorizedRole = 19;
                if ($userRole == $authorizedRole) {
                    $tableName = 'accounts';
                    $columns = ['id', 'Owner', 'AccountName', 'phone'];
                    $query = DB::table($tableName)->select($columns)->latest()->paginate(10);
                } else {
                    $errorMessage = "You are not authorized to access this data.";
                    return response()->json(['error' => $errorMessage], 403);
                }

                return $query;

            }

}