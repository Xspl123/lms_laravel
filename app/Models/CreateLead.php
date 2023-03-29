<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected $fillable = [
        'lead_Name', 'email', 'fullName','lead_Owner','phone','mobile','lead_status','user_id'
        ];
    use HasFactory;
}
