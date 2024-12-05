<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all_roles = [
            'project_manager',        // Manages project timelines, resources, and team coordination
            'accountant',             // Handles financial transactions, invoicing, and budgeting
            'director',               // Oversees overall project strategy and high-level decisions
            'team_lead',              // Leads specific project teams and coordinates task completion
            'resource_manager',       // Manages resource allocation and equipment
            'quality_assurance',      // Ensures quality standards are met in deliverables
            'business_analyst',       // Manages project requirements and stakeholder communication
            'developer',              // Implements and develops project solutions
            'client_relations',       // Manages client communication and feedback
        ];
        
        foreach ($all_roles as $role) {
            Role::create(['name' => $role]);
        }
        
        $permissions = [
            // Project Management
            'create project',
            'view project',
            'edit project',
            'delete project',
            'update project',
            'assign team members',

            // category Management
            'create category',
            'view category',
            'edit category',
            'delete category',
            'update category',

            // requistions Management
            'create requisitions',
            'view requisitions',
            'edit requisitions',
            'delete requisitions',
            'update requisitions',
            'approve requisitions',
            'upload requisitions',

            // projuect expenses
            'view expenses',
            'view report',
            'view invoice',
            'view files',
        
            // Task Management
            'create task',
            'view task',
            'edit task',
            'delete task',
            'update task',
        
            // Invoice Management
            'create invoice',
            'edit invoice',
            'delete invoice',
            'update invoice',
            'send invoice',

            // User Management
            'create user',
            'view user',
            'edit user',
            'delete user',
            'update user',
        
            // Financial Management
            'view financial reports',
            'manage project budget',
            'approve expenses',
            'process payments',
        
            // Client Management
            'create client',
            'view client',
            'edit client',
            'delete client',
            'update client',
        
            // Members Management
            'create members',
            'view members',
            'edit members',
            'delete members',
            'update members',

            // Department Management
            'create department',
            'view department',
            'edit department',
            'delete department',
            'update department',

            // Documents Management
            'create documents',
            'view documents',
            'edit documents',
            'delete documents',
            'update documents',
            
        
            // Admin Management
            'admin only',
            'create role',
            'edit role',
            'delete role',
            'update role',
            'update permission',
            'update settings',
            
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Assign all permissions to the director and project manager roles
        $directorRole = Role::where(['name' => 'director'])->first();
        $projectManagerRole = Role::where(['name' => 'project_manager'])->first();
        $permissions = Permission::all();
        $directorRole->syncPermissions($permissions);
        $projectManagerRole->syncPermissions($permissions);
        
        // Creating a Director user with full permissions
        $directorUser = User::factory()->create([
            'name' => 'Samuel',
            'first_name' => 'Samuel',
            'last_name' => 'Edu',
            'telephone_number' => '0754428612',
            'job_title' => 'Director',
            'department_id' => 1,
            'role' => 'director',
            'status' => 'active',
            'email' => 'samuelkiiraeluk@gmail.com',
            'password' => bcrypt('1234567890')
        ]);
        $directorUser->assignRole('director');

        $directorUser = User::factory()->create([
            'name' => 'Daniel',
            'first_name' => 'Daniel',
            'last_name' => 'Lodi',
            'telephone_number' => '0700274198',
            'job_title' => 'Director',
            'department_id' => 1,
            'role' => 'director',
            'status' => 'active',
            'email' => 'lodidannie@gmail.com',
            'password' => bcrypt('1234567890')
        ]);
        $directorUser->assignRole('director');

        $directorDev = User::factory()->create([
            'name' => 'Kenneth',
            'first_name' => 'Kenneth',
            'last_name' => 'Ogire',
            'telephone_number' => '0743338612',
            'job_title' => 'Director',
            'department_id' => 1,
            'role' => 'director',
            'status' => 'active',
            'email' => 'kennethogire@gmail.com',
            'password' => bcrypt('1234567890')
        ]);
        $directorDev->assignRole('director');
        
    }
}
