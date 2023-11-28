<?php

namespace App\Http\Controllers;

use App\Models\LeadPlatefrom;
use Illuminate\Http\Request;
use App\Models\CreateLead;
use App\Services\CreateLeadService;
use App\Http\Requests\CreateLeadRequest;


class LeadPlatefromController extends Controller
{
    private $createLeadService;
    
    public function __construct(CreateLeadService $createLeadService)
    {
        $this->createLeadService = $createLeadService;
    }

    public function index()
    {
        //
    }

    public function createLeadSource(CreateLeadRequest $request ,CreateLeadService $createLeadService)
    {
       
        $data = $request->validated();
        $lead = $createLeadService->leadSource($data);
        //$createLeadService->createLeadHistory($lead, 'Lead Created', 'Add');
        return response()->json(['message' => 'Lead created successfully','data' => $lead,]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
