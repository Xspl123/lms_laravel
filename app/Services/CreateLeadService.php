<?php

namespace App\Services;

use App\Models\CreateLead;
use App\Models\History;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CreateLeadService
{
    public function insertData(array $data):CreateLead
    {
        $leads = new CreateLead;
        $leads->uuid = $uuid = mt_rand(10000000, 99999999);
        $leads->lead_Name = $data['lead_Name'] ?? null;
        $leads->company = isset($data['company']) ? $data['company'] : null;
        $leads->email = $data['email'] ?? null;
        $leads->fullName = $data['fullName'] ?? null;
        $leads->lead_Source = $data['lead_Source'] ?? null;
        $leads->Owner = Auth::user()->uname;
        $leads->created_by = auth()->user()->id;
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
        $leads->role_id = auth()->user()->role_id;
        $leads->user_id = auth()->user()->id;
        $leads->save();
        Log::channel('create_leads')->info('A new lead has been created. lead data: '.$leads);
        return $leads;
    
    }

        public function createLeadHistory($leads, $feedback, $status)
        {
            $history = new History;
            $history->uuid = $leads->uuid;
            $history->process_name  = 'Lead';
            $history->created_by = $leads->Owner;
            $history->feedback = $feedback;
            $history->status = $status;
            $history->save();
            $history->save();
        }


        public function getLeads()
        {
            if (auth()->user()->role_id == 18) {
                $tableName = 'create_leads';
                $columns = ['*'];
            } else {
                $tableName = 'create_leads';
                $columns = ['*'];
                $userId = auth()->user()->id;
                $whereClause = ['user_id', '=', $userId];
            }

            $query = DB::table($tableName)->select($columns)->latest();

            if (isset($whereClause)) {
                $query->where($whereClause[0], $whereClause[1], $whereClause[2]);
            }

            $data = $query->paginate(10);

            return $data;
        }

}




