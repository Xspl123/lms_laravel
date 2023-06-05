<?php

namespace App\Events;

use App\Models\Company;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompanyCreated
{
    use Dispatchable, SerializesModels;

    public $company;
    public $cid;

    /**
     * Create a new event instance.
     *
     * @param  Company  $company
     * @param  int  $cid
     * @return void
     */
    public function __construct(Company $company, $cid)
    {
        $this->company = $company;
        $this->cid = $cid;
    }
}


