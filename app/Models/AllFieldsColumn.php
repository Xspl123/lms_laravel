<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllFieldsColumn extends Model
{
    protected $fillable = [
        'processName', 'fieldsName','Column_Name'
        ];
    use HasFactory;
}
