<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'cname', 'cemail', 'ctax_number', 'cphone', 'ccity','cbilling_address','ccountry','cpostal_code','cemployees_size','cfax','cdescription','domain_name', 'comanyOwner','fax','dateofBirth','mailingStreet','mailingCity','mailingState','mailingZip','mailingCountry','otherStreet','otherCity','otherState','otherZip','otherCountry','description', 'cis_active'
        ];

    use HasFactory;
}
