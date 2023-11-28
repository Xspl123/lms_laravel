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
        $account = $this->accountService->getdata(22);
        if (isset($account->message)) {
            // Display the error message to the user
            echo $account->message;
        } else {
            // Display the data to the user
            return response(['account' => $account], 200);
        }
    }

    public function updateAccount(Request $request, $uuid)
    {
        return $this->accountService->updateAccount($request, $uuid);
    }

    public function deleteAccount($id)
    {
        return $this->accountService->destroyAccount($id);
    }
}
