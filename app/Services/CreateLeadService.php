<?php

namespace App\Services;

use App\Models\CreateLead;
use App\Models\History;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CreateLeadService
{
    public function insertData($data)
    {
        $lead_Owner = Auth::user()->uname;
        $userId = Auth::id();
        $uuid = mt_rand(10000000, 99999999);
        $username = Auth::user()->uname;
        $roleId = auth()->user()->role_id;

        $leads = new CreateLead;
        $leads->uuid = $uuid;
        $leads->lead_Name = $data['lead_Name'] ?? null;
        $leads->company = isset($data['company']) ? $data['company'] : null;
        $leads->email = $data['email'] ?? null;
        $leads->fullName = $data['fullName'] ?? null;
        $leads->lead_Source = $data['lead_Source'] ?? null;
        $leads->Owner = $lead_Owner;
        $leads->created_by = $userId;
        $leads->fax = $data['fax'] ?? null;
        $leads->phone = $data['phone'] ?? null;
        $leads->mobile = $data['mobile'] ?? null;
        $leads->website = $data['website'] ?? null;
        $leads->lead_status = $data['lead_status'] ?? null;
        $leads->industry = $data['industry'] ?? null;
        $leads->rating = $data['rating'] ?? null;
        $leads->annualRevenue = $data['annualRevenue'] ?? null;
        $leads->skypeID = $data['skypeID'] ?? null;
        $leads->secondaryEmail = $data['secondaryEmail'] ?? null;
        $leads->twitter = $data['twitter'] ?? null;
        $leads->street = $data['street'] ?? null;
        $leads->pinCode = $data['pinCode'] ?? null;
        $leads->state = $data['state'] ?? null;
        $leads->country = $data['country'] ?? null;
        $leads->discription = $data['discription'] ?? null;
        $leads->role_id = $roleId;
        $leads->user_id = $userId;
        $leads->save();

    
        Log::channel('create_leads')->info('A new lead has been created. lead data: '.$leads);

        $history = new History;
        $history->uuid = $uuid;
        $history->process_name  = 'leads';
        $history->created_by = $username;
        $history->feedback = 'Lead Created';
        $history->status = 'Add';
        $history->save();

        return $leads;

        return $history;


    }
}




