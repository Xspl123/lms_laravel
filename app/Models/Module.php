<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected  $table ='modules';

    protected $fillable = [
        'module_name',
        'view',
        'create',
        'edit',
        'delete',
        'created_at',
        'updated_at',
        'profile_id'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
