<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{

    protected $fillable = ['dealOwner', 'dealName', 'accountName','type','amount','leadOwner',
            'closingDate', 'stage','probability','expectedRevenue','campaignSource','description','user_id'

        ];
    use HasFactory;
}
