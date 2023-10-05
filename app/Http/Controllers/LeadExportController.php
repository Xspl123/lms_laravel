<?php

namespace App\Http\Controllers;
use App\Exports\LeadExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class LeadExportController extends Controller
{
    public function exportLeads()
    {
        return Excel::download(new LeadExport, 'create_leads.xlsx');
    }
}
