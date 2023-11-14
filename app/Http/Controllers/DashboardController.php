<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Http\Models\CreateLead;
use Http\Models\Deal;

class DashboardController extends Controller
{
     
     //count lead  status wise 
    public function getLeadCount()
    {
        $leadStatuses = ['Pre-Qualified', 'Not-Qualified', 'Junk Lead', 'Not Contacted', 'Lost Lead','active','Follow up','open','Attempted to Contact','Contact in Future','inactive'];
        $leadCount = $this->createLeadService->getLeadCount($leadStatuses);

        return response()->json(['status_wise_lead_count' => $leadCount]);
    }

}
