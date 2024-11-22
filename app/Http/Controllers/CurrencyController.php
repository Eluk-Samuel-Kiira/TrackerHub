<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currencies = Currency::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'currencyIndexTable':
                return view('settings.currency.currency-component', [
                    'currencies' => $currencies,
                ]);
            default:
                return view('settings.currency-index', [
                    'currencies' => $currencies,
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
            'currency_code' => 'required|alpha|size:3|unique:currencies,name',
        ]);

        $currency = Currency::create([
            'name' => $request->currency_code,
            'created_by' => Auth::user()->id
        ]);

        
        if (isset($request->currency_page) && !empty($request->currency_page)) {

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'currencyIndexTable',
                'refresh' => false,
                'message' => __('Currency Created Successfully'),
                'redirect' => route('currencies.index'),
            ]);
        }

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

        $request->validate([
            'currency_code' => [
                'required',
                'alpha',
                'size:3',
                Rule::unique('currencies', 'name')->ignore($currency->id),
            ],
        ]);

        $currency->update([
            'name' => $request->currency_code,
            'created_by' => Auth::user()->id
        ]);

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'currencyIndexTable',
            'refresh' => false,
            'message' => __('Currency Updated Successfully'),
            'redirect' => route('currencies.index'),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        if ($currency->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This Currency Is Still Active!'),
            ]);
        }

        $currency->delete();
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'currencyIndexTable',
            'refresh' => false,
            'message' => __('Currency Deleted Successfully'),
            'redirect' => route('currencies.index'),
        ]);

    }


    public function changeCurrencyStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:1,0',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $currency = Currency::find($id);
    
        // Check if the user exists and update their status
        if ($currency) {
            $currency->isActive = $validated['status'];  // Directly update the status field
            if ($currency->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'currencyIndexTable',
                    'message' => __('Currency status updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Currency not found or status update failed!'),
        ]);
    }
}
