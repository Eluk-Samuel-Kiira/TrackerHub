<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Users\StoreEmployeeRequest;
use App\Http\Requests\Users\UpdateEmployeeRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $roles = Role::with('permissions')->latest()->get();
        $employees = User::latest()->get();

        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'reloadEmployeeComponent':
                return view('users.employee.user-component', [
                    'employees' => $employees,
                    'roles' => $roles,
                ]);
            default:
                return view('users.employee-index', [
                    'employees' => $employees,
                    'roles' => $roles,
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
    public function store(StoreEmployeeRequest $request)
    {
        $validatedData = $request->validated();

        // Generate username and password
        $username = Str::lower($validatedData['first_name'] . ' ' .$validatedData['last_name']);       
        $randomPassword = Str::random(10);
        $hashedPassword = Hash::make($randomPassword);

        // Merge additional data into the validated array
        $userData = array_merge($validatedData, [
            'name' => $username,
            'password' => $hashedPassword,
        ]);

        try {
            // Create user
            $user = User::create($userData);
            if ($user) {
                $user->assignRole($request->role);
                Mail::to($user->email)->send(new NewUserMail(
                    $user->first_name . ' ' . $user->last_name,
                    $user->role,
                    $user->departmentName->name,
                    $user->email,
                    $randomPassword
                ));
            }

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'reloadEmployeeComponent',
                'refresh' => false,
                'message' => __('Employee/User Created Successfully'),
                'redirect' => route('employee.index'),
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User creation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => __('Something Went Wrong!!'),
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        // Get the validated data
        $validatedData = $request->validated();

        // Get the authenticated user
        $authUser = auth()->user();

        // Check if the authenticated user has the required role
        if ($authUser && in_array($authUser->role, ['director', 'project_manager'])) {
            // Find the user by ID
            $user = User::find($id);

            // If the user is found, update their details
            if ($user) {
                // Update user details
                $user->update($validatedData);

                // Synchronize roles (if role has changed)
                if (isset($validatedData['role'])) {
                    $user->syncRoles($validatedData['role']);
                }

                // Return success response
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'componentId' => 'reloadEmployeeComponent',
                    'refresh' => false,
                    'message' => __('Employee/User Updated Successfully'),
                    'redirect' => route('employee.index'),
                ]);
            }

            // If user not found, return failure response
            return response()->json([
                'success' => false,
                'message' => __('User not found.'),
            ]);
        }

        // If authenticated user doesn't have the required role
        return response()->json([
            'success' => false,
            'message' => __('You don\'t have permissions to complete this action!'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user && !in_array($user->role, ['director', 'project_manager'])) { 
            $user->delete();
            
            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'reloadEmployeeComponent',
                'refresh' => false,
                'message' => __('Employee/User Deleted Successfully'),
                'redirect' => route('employee.index'),
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => __('This User Cannot Be Deleted!'),
        ]);
        
    }

    public function changeEmployeeStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $user = User::find($id);
    
        // Check if the user exists and update their status
        if ($user) {
            $user->status = $validated['status'];  // Directly update the status field
            if ($user->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'reloadEmployeeComponent',
                    'message' => __('User status updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('User not found or status update failed!'),
        ]);
    }
    
}
