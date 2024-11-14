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
        $clients = Client::where('isActive', 1)->get();
        $projectCategories = ProjectCategory::where('isActive', 1)->get();
        $currencies = Currency::where('isActive', 1)->get();
        $departments = Department::where('isActive', 1)->get();
        $users = User::where('status', 'active')->get();
        $roles = Role::all()->pluck('name');
        $projects = Project::with('projectCategory', 'department', 'client', 'currency', 'users')->paginate(10);
        return view('projects.index', compact('clients', 'projectCategories', 'currencies', 'departments', 'users', 'roles', 'projects'));
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
        //dd($request->all());

        $request->validate([
            "projectCode" => "required|string|unique:projects,projectCode",
            "projectName" => "required|string|unique:projects,projectName",
            "projectStartDate" => "required|date",
            "projectDeadlineDate" => "required|date",
            "projectDescription" => "required|string",
            "projectCategoryId" => "required|exists:project_categories,id",
            "projectDepartmentId" => "required|exists:departments,id",
            "projectClientId" => "required|exists:clients,id",
            "projectMemberIds" => "required",
            "projectBudget" => "required|numeric",
            "projectBudgetLimit" => "required|numeric",
            "projectCurrencyId" => "required|exists:currencies,id",
        ]);

        $project = Project::create([
            "projectCode" => $request->projectCode,
            "projectName" => $request->projectName,
            "projectStartDate" => $request->projectStartDate,
            "projectDeadlineDate" => $request->projectDeadlineDate,
            "projectDescription" => $request->projectDescription,
            "projectCategoryId" => $request->projectCategoryId,
            "projectDepartmentId" => $request->projectDepartmentId,
            "projectClientId" => $request->projectClientId,
            "projectBudget" => $request->projectBudget,
            "projectBudgetLimit" => $request->projectBudgetLimit,
            "projectCurrencyId" => $request->projectCurrencyId,
        ]);

        //user sync() when its update, attach() when its create
        $project->users()->attach($request->projectMemberIds);

       // Flash toast messages based on success or failure
        if ($project) {
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Project created successfully!',
            ]);
        } else {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Project creation failed!',
            ]);
        }

        return redirect()->route('projects.index');

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
