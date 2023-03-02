<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'productOwner','productName', 'productCode', 'vendorName', 'productActive', 'manufacturer','productCategory','salesStartDate','salesEndDate','supportStartDate','unitPrice','commissionRate','usageUnit','qtyOrdered','quantityinStock','reorderLevel','handler','quantityinDemand','description'
        ];
    use HasFactory;
}
