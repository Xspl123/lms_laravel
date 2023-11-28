<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use App\Models\{Country,State,City};
 
class CountryStateCityController extends Controller
{
 
    public function index()
    {
        $country =  DB::table('countries')
        ->select('countryName')
        //->where('countryName', 'India')
        ->get();

       //print_r($country); exit;

       return response([
        'country'=>$country,
        'status'=>'success'
    ], 200);
    }
    public function getState(Request $request)
    {
        $country =  DB::table('states')
        ->select('*')
        //->where('stateName', 'India')
        ->get();
 
    }
    public function getCity(Request $request)
    {
       
    }
 
}
