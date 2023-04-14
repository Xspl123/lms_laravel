<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function create_leads()
    {
        return $this->hasMany(CreateLead::class);
    }
    
    protected $fillable = [
        'cname','company','role','experience','email', 'ctax_number', 'location', 'industry', 'cphone','cemployees_size','cfax','cdescription'
        ];


        public function roles()
        {
            return $this->hasMany(Role::class);
        }    

        public function users()
        {
            return $this->hasMany(User::class);
        }

    use HasFactory;
}
