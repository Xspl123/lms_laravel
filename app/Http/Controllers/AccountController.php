<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\History;
use Illuminate\Http\Request;
use App\Services\AccountService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateAccountRequest;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
   
   
    public function createAccount(CreateAccountRequest $request,AccountService $accountService)
    {
        $data = $request->validated();
        $account = $this->accountService->insertData($data);
        $accountService->createHistory($account, 'Account Created', 'Add');
        return response(['message' => 'Account created Successfully','status'=>'success','account' => $account], 200);
    }

   
        public function showAccount(Account $account)
        {
            $account = $this->accountService->getdata();
            return response(['account' => $account], 200);

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

    
    public function destroy(Account $account)
    {
        //
    }
}
