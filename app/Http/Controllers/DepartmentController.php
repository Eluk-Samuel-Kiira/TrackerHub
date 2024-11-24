<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'departmentIndexTable':
                return view('home.department.department-component', [
                    'departments' => $departments,
                ]);
            default:
                return view('home.department-index', [
                    'departments' => $departments,
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
            'department_name' => 'required|string|max:255|unique:departments,name',
        ]);

        $department = Department::create([
            'name' => $request->department_name,
            'created_by' => Auth::user()->id
        ]);

        if (isset($request->department_page) && !empty($request->department_page)) {

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'departmentIndexTable',
                'refresh' => false,
                'message' => __('Department Created Successfully'),
                'redirect' => route('departments.index'),
            ]);
        }

        return response()->json(['success' => true, 'department' => $department]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => [
                'required',
                'max:255',
                Rule::unique('departments', 'name')->ignore($department->id),
            ],
        ]);

        $department->update([
            'name' => $request->department_name,
            'created_by' => Auth::user()->id
        ]);

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'departmentIndexTable',
            'refresh' => false,
            'message' => __('Department Updated Successfully'),
            'redirect' => route('departments.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        
        if ($department->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This Department Is Still Active!'),
            ]);
        }

        $department->delete();
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'departmentIndexTable',
            'refresh' => false,
            'message' => __('Department Deleted Successfully'),
            'redirect' => route('departments.index'),
        ]);
    }

    
    public function changeDepartmentStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:1,0',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $department = Department::find($id);
    
        if ($department) {
            $department->isActive = $validated['status']; 
            if ($department->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'departmentIndexTable',
                    'message' => __('Department status updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Department not found or status update failed!'),
        ]);
    }

    
}
