<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
