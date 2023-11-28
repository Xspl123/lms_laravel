<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $fillable = ['full_name', 'phone', 'email','job','note','uuid',
    'client_id', 'is_active','user_id'

    ]; 
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    protected $table = 'employees';
    use HasFactory;
}
