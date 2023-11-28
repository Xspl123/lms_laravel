<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'Owner',
        'AccountOwner',
        'AccountName',
        'AccountSite',
        'ParentAccount',
        'AccountNumber',
        'AccountType',
        'Industry',
        'AnnualRevenue',
        // 'Rating',
        'phone',
        'Fax',
        'Website',
        'TickerSymbol',
       // 'Ownership',
        'Employees',
        'SICCode',
        'BillingStreet',
        'BillingCity',
        'BillingState',
        'BillingCode',
        'BillingCountry',
        'ShippingStreet',
        'ShippingCity',
        'ShippingState',
        'ShippingCode',
        'ShippingCountry',
        'Description'
    ];
    use HasFactory;
}
