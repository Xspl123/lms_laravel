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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    protected $fillable = [
        'lead_Name', 'email', 'fullName','Owner','phone','mobile','lead_status','companies_id','user_id','role_id','uuid'
        ];
    use HasFactory;
}
