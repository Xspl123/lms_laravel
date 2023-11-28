<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\CreateLead;
use Illuminate\Support\Facades\Log;

class IndiaMartApiController extends Controller
{
    public function getIndiaMartApiRsponse()
    {
        try {
            $currentDateTime = Carbon::now();
            $start_date = $currentDateTime->format('d-M-Y00:00:0');
            $last_date = $currentDateTime->format('d-M-YH:i:s');
            $getdata = DB::table('indiamart')->first();
            $api_key = $getdata->crm_key;
            $url = $getdata->url;
            $fullUrl = "{$url}/?glusr_crm_key={$api_key}&start_time={$start_date}&end_time={$last_date}";

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $fullUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            Log::channel('india_mart_lead')->info('India Mart new lead: ' . $response);
              curl_close($curl);
             // echo $response;
                $responseData = json_decode($response, true);
                if($responseData['STATUS'] == 'SUCCESS')
                {
                        $insertData = $responseData['RESPONSE'];
                        foreach($insertData as $data)
                        {
                        $leadexist = DB::table('create_leads')->where('unique_query_id', $data['UNIQUE_QUERY_ID'])->first();
                        if (!$leadexist) {
                         $leads = new CreateLead;
                            $leads->uuid = $data['UNIQUE_QUERY_ID'];
                            $leads->unique_query_id = $data['UNIQUE_QUERY_ID'];
                            $leads->fullName = $data['SENDER_NAME'];
                            $leads->phone = $data['SENDER_MOBILE'];
                            $leads->email = $data['SENDER_EMAIL'];
                            $leads->lead_Name = $data['SUBJECT'];
                            $leads->lead_Source = 'India Mart';
                            $leads->lead_status ='New';
                            $leads->city = $data['SENDER_CITY'];
                            $leads->state = $data['SENDER_STATE'];
                            $leads->pinCode = $data['SENDER_PINCODE'];
                            $leads->country = $data['SENDER_COUNTRY_ISO'];
                            $leads->title = $data['QUERY_PRODUCT_NAME'];
                            $leads->discription = $data['QUERY_MESSAGE'];
                            $leads->company = $data['SENDER_COMPANY'];
                            $leads->Owner = 1;
                            $leads->role_id = 18;
                            $leads->owner_id = 1;
                            $leads->save();
                        }
                     }
                    return response()->json(['message' => 'Lead Created successfully']);
                }
                else{
                    return response()->json(['message' =>$responseData['MESSAGE']]);
                }
        }
         catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
