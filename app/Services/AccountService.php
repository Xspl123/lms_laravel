<?php

namespace App\Services;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountService {
   

    public function insertData($data)
    {
        $userId = Auth::User()->id; 
        $account = new Account();
        $account->AccountOwner = $data['AccountOwner'];
        $account->AccountName = $data['AccountName'];
        $account->AccountSite = $data['AccountSite'];
        $account->ParentAccount = $data['ParentAccount'];
        $account->AccountNumber = $data['AccountNumber'];
        $account->AccountType = $data['AccountType'];
        $account->Industry = $data['Industry'];
        $account->AnnualRevenue = $data['AnnualRevenue'];
        $account->Rating = $data['Rating'];
        $account->Phone = $data['Phone'];
        $account->Fax = $data['Fax'];
        $account->Website = $data['Website'];
        $account->TickerSymbol = $data['TickerSymbol'];
        $account->Ownership = $data['Ownership'];
        $account->Employees = $data['Employees'];
        $account->SICCode = $data['SICCode'];
        $account->BillingStreet = $data['BillingStreet'];
        $account->BillingCity = $data['BillingCity'];
        $account->BillingState = $data['BillingState'];
        $account->BillingCode = $data['BillingCode'];
        $account->BillingCountry = $data['BillingCountry'];
        $account->ShippingStreet = $data['ShippingStreet'];
        $account->ShippingCity = $data['ShippingCity'];
        $account->ShippingState = $data['ShippingState'];
        $account->ShippingCode = $data['ShippingCode'];
        $account->ShippingCountry = $data['ShippingCountry'];
        $account->Description = $data['Description'];
        $account->save();
        return $account;
    }
    

}