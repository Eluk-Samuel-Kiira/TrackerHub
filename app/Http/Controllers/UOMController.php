<?php

namespace App\Http\Controllers;

use App\Models\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UOMController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index(Request $request)
    {
        $uoms = UOM::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'uomIndexTable':
                return view('home.uom.uom-component', [
                    'uoms' => $uoms,
                ]);
            default:
                return view('home.umo-index', [
                    'uoms' => $uoms,
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
            'name' => 'required|string|max:255|unique:u_o_m_s,name',
        ]);

        $uom = UOM::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id
        ]);

        if (isset($request->umo_page) && !empty($request->umo_page)) {

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'uomIndexTable',
                'refresh' => false,
                'message' => __('UMO Created Successfully'),
                'redirect' => route('uoms.index'),
            ]);
        }

        return response()->json(['success' => true, 'uom' => $uom]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UOM $uOM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UOM $uOM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $uOM = UOM::find($id);
        
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('u_o_m_s', 'name')->ignore($uOM->id),
            ],
        ]);

        // \Log::info($uOM);


        $uOM->update([
            'name' => $request->name,
            'created_by' => Auth::user()->id
        ]);

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'uomIndexTable',
            'refresh' => false,
            'message' => __('UOM Updated Successfully'),
            'redirect' => route('uoms.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $uOM = UOM::find($id);
        
        if ($uOM->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This UOM Is Still Active!'),
            ]);
        }

        $uOM->delete();
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'uomIndexTable',
            'refresh' => false,
            'message' => __('UOM Updated Successfully'),
            'redirect' => route('uoms.index'),
        ]);
    }

    
    
    public function changeUOMStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:1,0',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $uom = UOM::find($id);
    
        if ($uom) {
            $uom->isActive = $validated['status']; 
            if ($uom->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'uomIndexTable',
                    'message' => __('UOM status updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('UOM not found or status update failed!'),
        ]);
    }
}
