<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    
    protected $fillable = ['p_id','remark','create_by','uuid'];

    public function getUuidAttribute()
    {
        return $this->attributes['uuid'];
    }
}
