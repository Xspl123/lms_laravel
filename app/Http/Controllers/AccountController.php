<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Services\AccountService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
   
   
    public function createAccount(Request $request,AccountService $accountService)
    {
        $request->validate([
            'AccountName' => 'required|string|max:255',
            'Phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{10}$/', $value)) {
                        $fail('The phone must be exactly 10 digits.');
                    }
                },
            ],
            
        ]);

        $account = $this->accountService->insertData($validatedData);
        return response(['message' => 'Account created Successfully','status'=>'success','account' => $account], 200);
    }

   
    public function show(Account $account)
    {
        //
    }

    
   
    public function update(Request $request, Account $account)
    {
        //
    }

    
    public function destroy(Account $account)
    {
        //
    }
}
