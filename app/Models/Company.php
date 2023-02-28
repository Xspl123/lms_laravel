<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }

    use HasFactory;
}
