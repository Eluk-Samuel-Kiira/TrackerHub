<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Project;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'clientsIndexTable':
                return view('projects.clients.client-component', [
                    'clients' => $clients,
                ]);
            default:
                return view('projects.client-index', [
                    'clients' => $clients,
                ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255|unique:clients,name',
            'client_email' => 'required|email|unique:clients,email',
            'client_phone' => 'required|string|unique:clients,phone',
            'client_address' => 'required|string',
        ]);

        $client = Client::create([
            'name' => $request->client_name,
            'email' => $request->client_email,
            'phone' => $request->client_phone,
            'address' => $request->client_address,
            'created_by' => Auth::user()->id
        ]);

        if (isset($request->client_page) && !empty($request->client_page)) {

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'clientsIndexTable',
                'refresh' => false,
                'message' => __('Client Created Successfully'),
                'redirect' => route('clients.index'),
            ]);
        }

        return response()->json(['success' => true, 'client' => $client]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'client_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients', 'name')->ignore($client->id),
            ],
            'client_email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
            'client_phone' => [
                'required',
                'string',
                Rule::unique('clients', 'phone')->ignore($client->id),
            ],
            'client_address' => 'required|string',
        ]);

        // Update the client's data
        $client->update([
            'name' => $request->client_name,
            'email' => $request->client_email,
            'phone' => $request->client_phone,
            'address' => $request->client_address,
        ]);
        
        
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'clientsIndexTable',
            'refresh' => false,
            'message' => __('Client Updated Successfully'),
            'redirect' => route('clients.index'),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client_to_project = Project::where('projectClientId', $client->id)->first();
        if ($client_to_project) {
            return response()->json([
                'success' => false,
                'message' => __('This Client Is Still Attached to a project!'),
            ]);
        }

        if ($client->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This Client Is Still Active!'),
            ]);
        }
    
        $client->delete();

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'clientsIndexTable',
            'refresh' => false,
            'message' => __('Client Deleted Successfully'),
            'redirect' => route('clients.index'),
        ]);
    }

    
    public function changeClientStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:1,0',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $client = Client::find($id);
    
        if ($client) {
            $client->isActive = $validated['status']; 
            if ($client->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'clientsIndexTable',
                    'message' => __('Client status updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Client not found or status update failed!'),
        ]);
    }
}
