<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_name', 'p_id','company_id'];

    public function parentRole()
    {
        return $this->belongsTo(Role::class, 'p_id');
    }


    public function childRoles() {
        return $this->hasMany(Role::class, 'p_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
 
}
