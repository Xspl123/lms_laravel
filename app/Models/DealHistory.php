<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealHistory extends Model
{
    use HasFactory;
    protected $fillable = ['Owner', 'dealName', 'accountName','type','amount',
    'closingDate', 'stage','probability','expectedRevenue','campaignSource','description','user_id','p_id'
    ,'owner_id','created_by','deal_id'
];
}
