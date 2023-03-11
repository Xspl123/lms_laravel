<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends Model
{
    protected $fillable = [
        'lead_Name', 'email', 'fName','lead_Owner','phone','mobile','lead_status','user_id'
        ];
    use HasFactory;
}
