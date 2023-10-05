<?php

namespace App\Imports;
use App\Models\CreateLead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new CreateLead([
            'id' => $row['id'],
            'uuid' => $row['uuid'],
            'related_activities' => $row['related_activities'],
            'lead_Name' => $row['lead_name'], // Change to match CSV/Excel header
            'company' => $row['company'],
            'email' => $row['email'],
            'lead_Source' => $row['lead_source'],
            'Owner' => $row['owner'],
            'created_by' => $row['created_by'],
            'modified_by' => $row['modified_by'],
            'fullName' => $row['full_name'],
            'fax' => $row['fax'],
            'phone' => $row['phone'],
            'mobile' => $row['mobile'],
            'website' => $row['website'],
            'lead_status' => $row['lead_status'],
            'industry' => $row['industry'],
            'rating' => $row['rating'],
            'noOfEmployees' => $row['Number of Employees'],
            'annualRevenue' => $row['annualrevenue'],
            'skypeID' => $row['skypeid'],
            'secondaryEmail' => $row['secondaryemail'],
            'twitter' => $row['twitter'],
            'city' => $row['city'],
            'street' => $row['street'],
            'pinCode' => $row['pincode'],
            'state' => $row['state'],
            'country' => $row['country'],
            'discription' => $row['discription'],
            'companies_id' => $row['companies_id'],
            'user_id' => $row['user_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'title' => $row['title'],
            'role_id' => $row['role_id'],
            'owner_id' => $row['owner_id'],
        ]);
    }
}
