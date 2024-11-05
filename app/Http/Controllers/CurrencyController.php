<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'currency_code' => 'required|unique:currencies,name'
        ]);

        $currency = Currency::create([
            'name' => $request->currency_code,
            'created_by' => Auth::user()->id
        ]);

        return response()->json(['success' => true, 'currency' => $currency]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
