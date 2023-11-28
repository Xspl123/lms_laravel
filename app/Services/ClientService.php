<?php

namespace App\Services;

use App\Models\Client;
use App\Models\History;
use Illuminate\Support\Facades\Auth;


class ClientService
{
    public function insertData(array $data):Client
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

    public function createHistory($deals, $feedback, $status)
    {
        $history = new History;
        $history->uuid = $deals->uuid;
        $history->process_name  = 'Client';
        $history->created_by = $deals->Owner;
        $history->feedback = $feedback;
        $history->status = $status;
        $history->save();
        
    }


    public function updateData($data)
    {
        // Find the data record in the database based on the ID
        $dataRecord = Data::find($data['id']);

        // Update the record with the new data
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
        
        // Save the updated record to the database
        $client->save();
    }
}

