<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contactOwner', 'firstName', 'accountName', 'email', 'phone','otherPhone','assistant','lastName','vendorName','title','department','homePhone','fax','dateofBirth','mailingStreet','mailingCity','mailingState','mailingZip','mailingCountry','otherStreet','otherCity','otherState','otherZip','otherCountry','description'
        ];
    use HasFactory;
}
