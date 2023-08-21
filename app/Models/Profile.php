<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_name', 
        'profile_description',
        'created_by',
        'modified_by',

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
