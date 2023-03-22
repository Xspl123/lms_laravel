<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =[
        'role_name'
    ];
    use HasFactory;


    public function parent()
    {
        return $this->belongsTo(Role::class, 'p_id');
    }

    public function children()
    {
        return $this->hasMany(Role::class, 'p_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function getRoleTree()
    {
        $roles = static::with('children')->whereNull('p_id')->get();
        
        return $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'role_name' => $role->role_name,
                'children' => $role->children->isNotEmpty() ? $role->children->getRoleTree() : null,
            ];
        });
    }
}
