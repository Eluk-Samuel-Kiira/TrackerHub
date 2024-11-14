<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->latest()->get();
        $permissions = Permission::all();

        $rolesWithUserCounts = $roles->map(function($role) {
            $role->user_count = User::whereHas('roles', function($query) use ($role) {
                $query->where('id', $role->id);
            })->count();
            return $role;
        });

        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'reloadRoleComponent':
                return view('users.roles.role-component', [
                    'roles' => $roles,
                    'permissions' => $permissions,
                ]);
            default:
                return view('users.role-index', [
                    'roles' => $rolesWithUserCounts,
                    'permissions' => $permissions,
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
        $validatedPermission = $request->validate([
            'permissions' => 'required|array|max:2225',  
            'permissions.*' => 'exists:permissions,id',  
            'name' => ['required','string','max:25','unique:roles,name','regex:/^\S+(\s\S+)?$/'] 
        ]);
        
        $userRole = Role::create([
            'name' => $validatedPermission['name'],
            'guard_name' => 'web'
        ]);
        
        $permissionNames = Permission::whereIn('id', $validatedPermission['permissions'])->pluck('name');
        $userRole->syncPermissions($permissionNames);
        
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'reloadRoleComponent',
            'refresh' => false,
            'message' => __('Role Created Successfully'),
            'redirect' => route('role.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedPermission = $request->validate([
            'permissions' => 'required|array|max:2225',  
            'permissions.*' => 'exists:permissions,id',  
            'name' => [
                'required',
                'string',
                'max:25',
                Rule::unique('roles', 'name')->ignore($id), // Ignore current role ID
                'regex:/^\S+(\s\S+)?$/'
            ]
        ]);

        try {

            // Find the user role by ID and ensure it's not a restricted role
            $userRole = Role::where('id', $id)  // Use the provided ID parameter
                ->whereNotIn('name', ['director'])
                ->first();
            
            // If the role exists, sync the permissions
            if ($userRole) {
                $permissions = Permission::whereIn('id', $validatedPermission['permissions'])->pluck('name');
                $userRole->syncPermissions($permissions);
            } else{
                return response()->json([
                    'success' => false,
                    'message' => __('Role Cannot Be Updated'), 
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), 
            ]);
        }

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'reloadRoleComponent',
            'refresh' => false,
            'message' => __('Role Updated Successfully'),
            'redirect' => route('role.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        // If the role doesn't exist, return an error response
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => __('Role not found.'),
            ]);
        }

        // Check if any user is currently associated with this role
        $user = User::where('role', $role->name)->first();

        // If users are still assigned to this role, return an error response
        if ($user) {
            return response()->json([
                'success' => false,
                'message' => __('There are users still attached to this role.'),
            ]);
        }

        // Check if the role is deletable (i.e., not a special role like 'director', 'developer', etc.)
        $deletableRole = Role::where('id', $id)
            ->whereNotIn('name', ['director', 'developer', 'resource_manager'])
            ->first();

        // If the role is deletable, delete it and return a success response
        if ($deletableRole) {
            $deletableRole->delete();

            return response()->json([
                'success' => true,
                'message' => __('Role deleted successfully'),
                'reload' => true,
                'componentId' => 'reloadRoleComponent',
                'refresh' => false,
                'redirect' => route('role.index'),
            ]);
        }

        // If the role cannot be deleted (i.e., it's one of the special roles), return an error response
        return response()->json([
            'success' => false,
            'message' => __('This role cannot be deleted.'),
        ]);
    }


    public function permissionIndex(Request $request) 
    {
        $users = User::with('permissions')->latest()->get();
        $permissions = Permission::all();

        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'reloadPermissionComponent':
                return view('users.permissions.permission-component', [
                    'users' => $users,
                    'permissions' => $permissions,
                ]);
            default:
                return view('users.permissions-index', [
                    'users' => $users,
                    'permissions' => $permissions,
                ]);
        }

    }

    public function updatePermission(Request $request, $user_id)
    {
        // Validate the input permissions
        $validatedPermission = $request->validate([
            'permissions' => 'required|array|max:2225',  
            'permissions.*' => 'exists:permissions,id',  
        ]);

        try {
            $user = User::findOrFail($user_id);

            $permissions = Permission::whereIn('id', $validatedPermission['permissions'])->pluck('name');

            // Attach the permissions directly to the user (not via roles)
            $user->syncPermissions($permissions);

            return response()->json([
                'success' => true,
                'message' => __('Permissions updated successfully'),
                'reload' => true,
                'componentId' => 'reloadPermissionComponent',
                'refresh' => false,
                'redirect' => route('permission.index'),

            ]);
            

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), 
            ]);
        }
    }

    

}
