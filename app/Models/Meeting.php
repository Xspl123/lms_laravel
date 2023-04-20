<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected  $fillable = [
        'title','location','allday','from','to','host','participants','related','contactName','contactNumber','repeat','participantsRemainder','description','reminder'
    ];
    use HasFactory;
}
