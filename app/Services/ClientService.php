<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;


class ClientService
{
    public function insertData($data)
    {
        $userId = Auth::User()->id; 
        $client = new Client();
        $client->clfull_name = $data['clfull_name'];
        $client->clphone = $data['clphone'];
        $client->clemail = $data['clemail'];
        $client->clsection = $data['clsection'];
        $client->clbudget = $data['clbudget'];
        $client->cllocation = $data['cllocation'];
        $client->clzip = $data['clzip'];
        $client->clcity = $data['clcity'];
        $client->clcountry = $data['clcountry'];
        $client->user_id = $userId;
        $client->save();
        return $client;
    }
}

