<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addClient(Request $request)
    {
        // $userId = Auth::uname();
        $userId = Auth::User()->id;  
        //print_r($userId);exit;
        //echo "addcomany"; die;
        $rules = [
            'clfull_name' => 'required',
            'clphone' => 'required',
            'clemail' => 'required|email|unique:clients,clemail',
            'clsection' => 'required',
            'clbudget' => 'required',
            'cllocation' => 'required',
            'clzip' => 'required',
            'clcity' => 'required',
            'clcountry' => 'required'
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            $client = new Client;
            
            $client->clfull_name = $request->clfull_name;
            $client->clphone = $request->clphone;
            $client->clemail = $request->clemail;
            $client->clsection = $request->clsection;
            $client->clbudget = $request->clbudget;
            $client->cllocation = $request->cllocation;
            $client->clzip = $request->clzip;
            $client->clcity = $request->clcity;
            $client->clcountry = $request->clcountry;
            $client->user_id = $userId;
            $client->save();

            return response()->json(['message' => 'Client Added successfully','client' => $client], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function showClientList(Client $client)
    {
        $userId = Auth::id();
        $clients = Client::join('users', 'clients.user_id', '=', 'users.id')
                   ->select('clients.*')
                   ->where('users.id', $userId)
                   ->limit(10)
                   ->orderBy('id', 'desc')
                   ->get();
                   
        return response([
            'clients'=>$clients,
            'status'=>'success'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function updateClient(Request $request, Client $client ,$id)
    {
        //echo "hello update";

        $client = Client::find($id);
        //print_r($client); exit;
        if (!$client) {
           return response()->json(['message' => 'Client not found']);

        }

        $client->update($request->all());
           
            return response()->json(['message' => 'Client Updated successfully','client' => $client]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroyClient(Client $client ,$id)
    {
        //echo "hello client"; exit;
        $client = Client::find($id);
        if (!$client) {
           return response()->json(['message' => 'Client not found']);
        }

        $client->delete();

        return response()->json(['message'=>'Client deleted successfully']);
    }
}
