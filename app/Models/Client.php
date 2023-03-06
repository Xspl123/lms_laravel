<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    public function companies()
    {
        return $this->hasMany(Company::class, 'id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'id');
    }
    protected $fillable = [
        'clfull_name',
        'clphone',
        'clemail',
        'clsection',
        'clbudget',
        'cllocation',
        'clzip',
        'clcity',
        'clcountry',
    ];
    use HasFactory;
}
