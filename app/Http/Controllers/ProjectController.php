<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Currency;
use App\Models\Department;
use App\Models\User;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

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
            "projectCost" => "required|numeric",
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
            "projectCost" => $request->projectCost,
            "projectBudget" => $request->projectBudget,
            "projectBudgetLimit" => $request->projectBudgetLimit,
            "projectCurrencyId" => $request->projectCurrencyId,
            'created_by' => Auth::user()->id,
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
        // Get users not attached to the given project
        $users = User::where('status', 'active')
        ->whereDoesntHave('projects', function ($query) use ($project) {
            $query->where('projects.id','=', $project->id);
        })
        ->get();

        $roles = Role::all()->pluck('name');
        $departments = Department::where('isActive', 1)->get();
        $documentTypes = DocumentType::where('isActive', 1)->get();
        return view('projects.show', compact('project','users', 'roles', 'departments', 'documentTypes'));
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

    public function removeUser(Project $project, User $user)
    {
        if(count($project->users) == 1){
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Cannot remove the last user from the project.',
            ]);
            return redirect(url('projects/'.$project->id.'#members'));
        }

        // Detach the user from the project (if many-to-many relationship)
        if ($project->users()->detach($user)) {
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'User removed from the project successfully.',
            ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to remove the user from the project.',
            ]);
        }
        return redirect(url('projects/'.$project->id.'#members'));
    }

    public function addUsers(Project $project, Request $request){
        $request->validate([
            'projectMemberIds' => 'required',
        ]);

        // Attach the user to the project (if many-to-many relationship)
        if ($project->users()->syncWithoutDetaching($request->projectMemberIds)) {
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Users added to the project successfully.',
            ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to add users to the project.',
            ]);
        }
        return redirect(url('projects/'.$project->id.'#members'));
    }
}
