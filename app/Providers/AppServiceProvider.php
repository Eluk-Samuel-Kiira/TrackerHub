<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $departments = Department::where('isActive', 1)->get();
        $roles = Role::all()->pluck('name');
        
        View::share([
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }
}
