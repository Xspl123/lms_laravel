<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\TableHelper;

class DealHistory extends Model
{
    use HasFactory;
    protected $fillable = ['Owner', 'dealName', 'accountName','type','amount',
    'closingDate', 'stage','probability','expectedRevenue','campaignSource','description','user_id','p_id'
    ,'owner_id','created_by','deal_id'
];

public function show_deal_histories()
{
    $deal_histories = TableHelper::getTableData('deal_histories', ['*']);
    
    return response()->json(['status' => 'success','deal_histories' => $deal_histories,], 200);
    
}

}
