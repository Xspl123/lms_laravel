<?php

namespace App\Http\Controllers;
use App\Services\CreateLeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Http\Models\CreateLead;
use Http\Models\Deal;
use App\Helpers\TableHelper;

class DashboardController extends Controller
{
     
    private $createLeadService;
    
    public function __construct(CreateLeadService $createLeadService)
    {
        $this->createLeadService = $createLeadService;
    }
     //count lead  status wise 
    public function getLeadCount()
    {
        $leadStatuses = ['PreQualified', 'NotQualified', 'JunkLead', 'NotContacted', 'Contacted', 'LostLead','active','Followup','New','Open','AttemptedContact','ContactFuture','inactive'];
        $leadCount = $this->createLeadService->getLeadCountStatusWise($leadStatuses);
         
        return [
            'LeadData' => $leadCount,
            'Dealdata' => $this->getDealAmountStageWise(),
        ];
        
    }


    // public function getDealAmountStageWise()
    // {
    //     // Assuming $data_list contains your table data
    //     $data_list = TableHelper::getTableDataCount('deals', ['*']);

    //     // Initialize an array to store the sum of amounts for each stage
    //     $stageAmounts = [];

    //     // Iterate through the data
    //     foreach ($data_list as $deal) {
    //         // Assuming 'stage' and 'amount' are properties of the $deal object
    //         $stage = $deal->stage;
    //         $amount = $deal->amount;

    //         // If the stage is not already in the array, initialize it with the current amount
    //         if (!isset($stageAmounts[$stage])) {
    //             $stageAmounts[$stage] = $amount;
    //         } else {
    //             // If the stage is already in the array, add the current amount to the existing sum
    //             $stageAmounts[$stage] = $amount;
    //         }
    //     }

    //     // Prepare the result as an associative array
    //     $result = [];
    //     foreach ($stageAmounts as $stage => $sum) {
    //         $result[] = ['stage' => $stage, 'sum_of_amounts' => $sum];
    //     }

    //     // Return the result as JSON response
    //     return $result;
    // }

    public function getDealAmountStageWise()
    {
        // Assuming $data_list contains your table data
        $data_list = TableHelper::getTableDataCount('deals', ['*']);

        // Initialize an array to store the sum of amounts and count for each stage
        $stageData = [];

        // Iterate through the data
        foreach ($data_list as $deal) {
            // Assuming 'stage' and 'amount' are properties of the $deal object
            $stage = $deal->stage;
            $amount = $deal->amount;

            // If the stage is not already in the array, initialize it with the current amount and count
            if (!isset($stageData[$stage])) {
                $stageData[$stage] = ['sum_of_amounts' => $amount, 'count' => 1];
            } else {
                // If the stage is already in the array, add the current amount to the existing sum and increment the count
                $stageData[$stage]['sum_of_amounts'] += $amount;
                $stageData[$stage]['count']++;
            }
        }

        // Prepare the result as an associative array
        $result = [];
        foreach ($stageData as $stage => $data) {
            $result[] = ['stage' => $stage, 'sum_of_amounts' => $data['sum_of_amounts'], 'count' => $data['count']];
        }

        // Return the result as a JSON response
        return $result;
    }
}
