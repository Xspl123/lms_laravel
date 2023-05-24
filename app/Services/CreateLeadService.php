<?php

namespace App\Services;
use Predis\Client;
use Predis\Connection\ConnectionException;
use App\Models\CreateLead;
use App\Models\History;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CreateLeadService
{
    public function insertData(array $data): CreateLead
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
    
        try {
            $redis = new Client();
            $redisKey = 'createleads:' . $leads->uuid;
            $redis->hmset($redisKey, [
                'lead_Name' => $leads->lead_Name,
                'email' => $leads->email,
                'fullName' => $leads->fullName,
                'Owner' => $leads->Owner,
                'phone' => $leads->phone,
                'mobile' => $leads->mobile,
                'lead_status' => $leads->lead_status,
                'companies_id' => $leads->companies_id,
                'user_id' => $leads->user_id,
                'role_id' => $leads->role_id,
                'uuid' => $leads->uuid,
            ]);
        } catch (ConnectionException $exception) {
            // Handle connection exception if needed

        }
    
        Log::channel('create_leads')->info('A new lead has been created. lead data: ' . $leads);
    
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
            
        }
        public function getLeadData($leadId)
        {
            $redis = new Client();
            $redisKey = 'createleads:' . $leadId;
            $leadData = $redis->hmget($redisKey, ['fullName', 'phone']);
    
            return [
                'fullName' => $leadData[0] ?? null,
                'phone' => $leadData[1] ?? null,
            ];
        }

        public function getdata($authorizedRoleId)
        {
            $userRole = auth()->user()->role_id;
            //print_r($userRole);exit;
            $tableName = 'create_leads';
            $columns = ['*'];

            if ($userRole == $authorizedRoleId) {
                $query = DB::table($tableName)
                        ->where('user_id', auth()->user()->id)
                        ->select($columns)
                        ->latest()
                        ->paginate(10);
            } else {
                $errorMessage = "You are not authorized to access this data.";
                return response()->json(['message' => $errorMessage], 403);
            }

            return $query;
        }

        public function updateLead(Request $request, $uuid)
        {
            $leads = CreateLead::where('uuid', $uuid)->first();
            if (!$leads) {
                return response()->json(['message' => 'Lead not found'], 404);
            }
    
            $originalData = clone $leads;
    
            $leads->update($request->all());
    
            $changes = $leads->getChanges();
    
            if (empty($changes)) {
                return response()->json(['message' => 'No changes detected'], 400);
            }
            $column = key($changes);
            $before = $originalData->$column;
            $after = $changes[$column];
            $feedback = "$column was updated from $before to $after";
    
            $history = new History;
            $history->uuid = $uuid;
            $history->process_name = 'Lead';
            $history->created_by = Auth::user()->uname;
            $history->feedback = $feedback;
            $history->status = 'Updated';
            $history->save();
            Log::channel('update_leads')->info("Lead has been updated. $feedback");
        
            return response()->json(['message' => 'Lead has been updated'], 200);
        } 
        

        public function getLeadCount($leadStatuses)
        {
            $leadCounts = CreateLead::whereIn('lead_status', $leadStatuses)
            ->groupBy('lead_status')
            ->selectRaw('lead_status, count(*) as count')
            ->get()
            ->pluck('count', 'lead_status');
            return $leadCounts;
        }

    }


