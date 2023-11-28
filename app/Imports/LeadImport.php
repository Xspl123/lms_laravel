<?php

namespace App\Imports;
use App\Models\CreateLead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = Auth::user();
        $uuid = mt_rand(10000000, 99999999);
        $role_id = $user->role_id;

        return new CreateLead([
            'related_activities' => $row['related_activities'],
            'lead_Name' => $row['lead_name'],
            'email' => $row['email'],
            'lead_Source' => $row['lead_source'],
            'Owner' => $user->uname,
            'fullName' => $row['full_name'],
            'phone' => $row['phone'],
            'website' => $row['website'],
            'lead_status' => $row['lead_status'],
            'secondaryEmail' => $row['secondary_email'],
            'city' => $row['city'],
            'annualRevenue' => $row['annual_revenue'],
            'street' => $row['street'],
            'pinCode' => $row['pin_code'],
            'state' => $row['state'],
            'country' => $row['country'],
            'description' => $row['description'],
            'uuid' => $uuid,
            'role_id' => $role_id,
            'owner_id' => $user->id ,
            'user_id' => $user->id ,
            'created_by' => $user->id ,
        ]);
    }
}
