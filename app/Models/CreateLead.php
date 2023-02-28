<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends Model
{
    protected $fillable = [
        'lead_Name', 'company', 'email', 'lead_Source', 'lead_Owner','first_Name','last_Name','titel','fax','mobile','website','lead_status','industry','tr','user_id'
        ];
    use HasFactory;
}
