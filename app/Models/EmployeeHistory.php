<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHistory extends Model
{
    protected $table = 'employee_history'; 

    protected $fillable = ['full_name', 'phone', 'email','job','note','uuid',
    'client_id', 'is_active','user_id'

    ]; 

    use HasFactory;
}
