<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Currency;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('isActive', 1)->get();
        $projectCategories = ProjectCategory::where('isActive', 1)->get();
        $currencies = Currency::where('isActive', 1)->get();
        $departments = Department::where('isActive', 1)->get();
        $users = User::where('status', 'active')->get();
        $roles = Role::all()->pluck('name');
        return view('projects.create', compact('clients', 'projectCategories', 'currencies', 'departments', 'users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
