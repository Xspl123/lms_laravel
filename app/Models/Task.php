<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'Subject', 'DueDate', 'Status', 'Priority', 'Reminder','Repeat','Description'
        ];
    use HasFactory;
}
