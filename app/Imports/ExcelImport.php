<?php

namespace App\Imports;

use App\Models\CreateLead;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CreateLead([
            'uuid' => $row['0'],
            'lead_Name' => $row['1'],
            'company' => $row['2'],
            'email' => $row['3'],
            'lead_Source' => $row['4'],
            'lead_Owner' => $row['5'],
            'created_by' => $row['6'],
            'modified_by' => $row['7'],
            'fullName' => $row['8'],
            'fax' => $row['9'],
            'phone' => $row['10'],
            'mobile' => $row['11'],
            'website ' => $row['12'],
            'lead_status' => $row['13'],
            'industry' => $row['14'],
            'rating' => $row['15'],
            'noOfEmployees' => $row['16'],
            'annualRevenue' => $row['17'],
            'skypeID' => $row['18'],
            'secondaryEmail' => $row['19'],
            'twitter' => $row['20'],
            'city' => $row['21'],
            'street' => $row['22'],
            'pinCode ' => $row['23'],
            'state' => $row['24'],
            'country' => $row['25'],
            'discription' => $row['26'],
            'companies_id' => $row['27'],
            'user_id' => $row['28'],
            'created_at' => $row['29'],
            'updated_at' => $row['30'],
            'title' => $row['31'],   
        ]);
    }
}
