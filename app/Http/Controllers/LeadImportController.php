<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\LeadImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class LeadImportController extends Controller
{
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            try {
                Excel::import(new LeadImport, $file);
                return response()->json(['message' => 'Data imported successfully'], Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error importing data', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return response()->json(['message' => 'No file provided'], Response::HTTP_BAD_REQUEST);
    }
}
