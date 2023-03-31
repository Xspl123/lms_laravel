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
        'lead_Name', 'email', 'fullName','lead_Owner','phone','mobile','lead_status','user_id'
        ];
    use HasFactory;
}
