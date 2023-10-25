<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Client;
use App\Http\Requests\CreateClientRequest;
use App\Helpers\TableHelper;
use App\Helpers\ApplicationUpdater;
use App\Services\ClientService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    public function index()
    {
        
    }

    
    public function create()
    {
        //
    }

    
    public function addClient(CreateClientRequest $request, ClientService $clientService)
    {
        $data = $request->validated();
        $clients = $this->clientService->addDeal($data);
        $p_id=$data['p_id'];
        $clientService->createHistory($clients, 'Client Created', 'Add',$p_id);

        
        return response()->json(['message' => 'Client Added successfully','client' => $client], 201);
    }

    public function showClientList(Client $client)
    {
        $clients = TableHelper::getTableData('clients', ['*']);
        //$users = TableHelper::getTableData('users', ['id','uname','urole']);
    
        $data = [
            'clients' => $clients,
            //'users' => $users,
        ];
    
        return response()->json($data);
    }

   
    public function edit(Client $client)
    {
        //
    }

   
    public function updateClient(Request $request,$id)
    {
        $client = Client::findOrFail($id);
        
        $updatedClient = ApplicationUpdater::update($client, $request->all());

        return response()->json(['client' => $updatedClient], 200);
    }

    
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