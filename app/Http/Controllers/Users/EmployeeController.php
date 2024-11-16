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
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

}
