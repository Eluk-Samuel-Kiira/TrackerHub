<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Currency;
use App\Models\Department;
use App\Models\User;
use App\Models\ProjectMeeting;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\removeOrAddUserMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


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
        $documentTypes = DocumentType::where('isActive', 1)->get();
        
        if (in_array(auth()->user()->role, ['director', 'project_manager', 'accountant'])) {
            $projects = Project::with('projectCategory', 'department', 'client', 'currency', 'users', 'tasks')->latest()->get();
        } else {
            
            // Get project IDs associated with the user
            $project_ids = DB::table('project_user')
                            ->where('user_id', auth()->user()->id)
                            ->pluck('project_id'); // Fetch only project IDs

            $projects = Project::whereIn('id', $project_ids)->with('projectCategory', 'department', 'client', 'currency', 'users', 'tasks')->latest()->get();
        }

        // Calculate percentage completion for each project
        $projects->each(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->whereNotNull('completionDate')->count();
            $project->percentageCompletion = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        });

        return view('projects.index', compact('clients', 'projectCategories', 'currencies', 'departments', 'users', 'roles', 'projects', 'documentTypes'));
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

        \Log::info($request->all());
        // Clear application cache
        Artisan::call('optimize:clear');

        
        if ($request->documentName || $request->hasFile('document')) {
            $request->validate([
                'documentName'=>'required|string|unique:project_files,document_name',
                'documentTypeId'=> 'required',
                'document'=> 'file',
            ]);
        }


        $request->validate([
            // "projectCode" => "required|string|unique:projects,projectCode",
            "projectName" => "required|string|unique:projects,projectName",
            "projectStartDate" => "required|date",
            "projectDeadlineDate" => "required|date",
            "projectDescription" => "required|string",
            'meetingDate' => 'required|date|after:now',
            "projectCategoryId" => "required|exists:project_categories,id",
            // "projectDepartmentId" => "required|exists:departments,id",
            "projectClientId" => "required|exists:clients,id",
            "projectMemberIds" => "required",
            "projectCost" => "required|numeric|gte:projectBudget", // Ensure projectCost is greater than or equal to projectBudget
            "projectBudget" => "required|numeric",
            "projectBudgetLimit" => [
                "required",
                "numeric",
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->projectBudget) {
                        $fail("The $attribute cannot be greater than the project budget.");
                    }
                },
            ],
            "projectCurrencyId" => "required|exists:currencies,id",
        ]);
        
        do {
            $projectCode = 'PRJ-' . strtoupper(Str::random(6));
        } while (Project::where('projectCode', $projectCode)->exists());

        $project = Project::create([
            "projectCode" => $projectCode,
            "projectName" => $request->projectName,
            "projectStartDate" => $request->projectStartDate,
            "projectDeadlineDate" => $request->projectDeadlineDate,
            "projectDescription" => $request->projectDescription,
            "projectCategoryId" => $request->projectCategoryId,
            "projectDepartmentId" => 2,
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

            // Meeting Location
            $projectMeeting = DB::table('project_meetings')->insert([
                'project_id' => $project->id,
                'meetingDate' => $request->meetingDate,
                'meetingType' => $request->meetingType,
                'meetingLocation' => $request->meetingLocation,
                'status' => 0,
                'created_at' => now(), 
                'updated_at' => now(),
            ]);

            if ($request->documentName) {

                if (!Storage::disk('public')->exists('uploads')) {
                    Storage::disk('public')->makeDirectory('uploads');
                }
        
                $documentPath = $request->file('document')->storeAs('uploads', time() . '_' . $request->file('document')->getClientOriginalName(), 'public');
        
                $projectFile = ProjectFile::create([
                    'project_id'=>$request->project->id,
                    'document_name'=>$request->documentName,
                    'document_path'=>$documentPath,
                    'created_by'=>Auth::user()->id,
                    'document_type'=>$request->documentTypeId,
                ]);
            }
            
            $users = User::whereIn('id', $request->projectMemberIds)->get();
            
            $action = 'add_user';
            foreach ($users as $user) {
                $this->removeOrAddUserToProjectMail($request, $user, $action);
            }


            // session()->flash('toast', [
            //     'type' => 'success',
            //     'message' => 'Project created successfully!',
            // ]);

            return response()->json([
                'success' => true,
                'message' => __('Project Created Successfully'),
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

        
        $completedTasks = $project->tasks->whereNotNull('completionDate');

        $totalTasks = $project->tasks->count();
        $completedCount = $completedTasks->count();

        $percentageCompletion = $totalTasks > 0 ? ($completedCount / $totalTasks) * 100 : 0;

        $roles = Role::all()->pluck('name');
        $clients = Client::where('isActive', 1)->get();
        $departments = Department::where('isActive', 1)->get();
        $documentTypes = DocumentType::where('isActive', 1)->get();
        return view('projects.show', compact('percentageCompletion', 'clients', 'project','users', 'roles', 'departments', 'documentTypes'));
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
    public function update(Request $request,$id)
    {
        $project = Project::find($id);

        $request->validate([
            "projectCode" => "required|string",
            "projectName" => "required|string",
            "projectStartDate" => "required|date",
            "projectDeadlineDate" => "required|date",
            "projectDescription" => "required|string",
            "projectCategoryId" => "required|exists:project_categories,id",
            "projectDepartmentId" => "required|exists:departments,id",
            "projectClientId" => "required|exists:clients,id",
            "projectCost" => "required|numeric|gte:projectBudget", // Ensure projectCost is greater than or equal to projectBudget
            "projectBudget" => "required|numeric",
            "projectBudgetLimit" => [
                "required",
                "numeric",
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->projectBudget) {
                        $fail("The $attribute cannot be greater than the project budget.");
                    }
                },
            ],
            "projectCurrencyId" => "required|exists:currencies,id",
        ]);

        $project->update([
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
        ]);
        \Log::info('yes');

        // Flash toast messages based on success or failure
        if ($project) {
            // session()->flash('toast', [
            //     'type' => 'success',
            //     'message' => 'Project updated successfully!',
            // ]);

            return response()->json([
                'success' => true,
                'message' => __('Project Updated Successfully'),
            ]);

        } else {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Project update failed!',
            ]);
        }

        return redirect()->route('projects.index');
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
            // \Log::info($project);
            $action = 'remove_user';
            $this->removeOrAddUserToProjectMail($project, $user, $action);

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

    
    private function removeOrAddUserToProjectMail($project, $user, $action)
    {
        if (getMailOptions('mail_status') === 'enabled') {
            // Define email content
            $companyName = getMailOptions('app_name');
            if ($action == 'remove_user') {
                $subject = sprintf(
                    'Notice of removal from %s Project',
                    $project->projectName,
                );
                $emailMessage = sprintf(
                    "Hello %s,\nThis is to inform or remind you that you have been removed/detached from the above project.\n".
                    "You'll either wait for new allocations or be shifted to another project.\n\nThank you,\n%s",
                    $user->name,
                    $companyName,
                );
            } elseif ($action == 'add_user') {
                $subject = sprintf(
                    'Notice of Addition to %s Project',
                    $project->projectName,
                );
                $emailMessage = sprintf(
                    "Hello %s,\n\nThis is to inform or remind you that you have been allocated/attached to the above project.\n" .
                    "The first meeting is scheduled on %s.\n\n" .
                    "You are required to start accomplishing the assigned tasks with deadlines in mind.\n\n" .
                    "Thank you,\n%s",
                    $user->name,
                    \Carbon\Carbon::parse($project->meetingDate)->format('F j, Y g:i A'),
                    $companyName
                );                
            } elseif ($action['type'] === 'send_reminder') {
                $subject = sprintf(
                    'Notice of Next Scheduled Meeting for %s Project',
                    $project->projectName
                );
        
                $emailMessage = sprintf(
                    "Hello %s,\n\nThis is to inform or remind you that there is a scheduled meeting to the '%s' project.\n" .
                    "The next meeting is scheduled on %s.\n\n" .
                    "You are required to start accomplishing the assigned tasks with deadlines in mind.\n\n" .
                    "Thank you,\n%s",
                    $user->name,
                    $project->projectName,
                    \Carbon\Carbon::parse($action['meetingDate'])->format('F j, Y g:i A'),
                    $companyName,
                );
            }

            $content = [
                'subject' => $subject,
                'emailMessage' => $emailMessage, // Use this key
                'companyName' => $companyName,
                'username' => $user->name,
                'projectName' => $project->projectName,
            ];

            // Send email to the user
            Mail::to($user->email)->send(new removeOrAddUserMail($content));
        }
    }


    public function addUsers(Project $project, Request $request){
        $request->validate([
            'projectMemberIds' => 'required',
        ]);
        $users = User::whereIn('id', $request->projectMemberIds)->get();
        
        // Attach the user to the project (if many-to-many relationship)
        if ($project->users()->syncWithoutDetaching($request->projectMemberIds)) {
            $action = 'add_user';
            foreach ($users as $user) {
                $this->removeOrAddUserToProjectMail($project, $user, $action);
            }

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

    public function meetingDestroy($id)
    {
        $meeting = ProjectMeeting::findOrFail($id);

        if ($meeting->status == 0 && \Carbon\Carbon::parse($meeting->meetingDate)->isFuture()) {
            $meeting->delete();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Meeting deleted successfully.',
            ]);
            return redirect(url('projects/'.$meeting->project_id.'#meetings'));
        }
        session()->flash('toast', [
            'type' => 'error',
            'message' => 'Cannot delete a meeting that has already occurred and is not marked as done..',
        ]);

        return redirect(url('projects/'.$meeting->project_id.'#meetings'));
    }
    
    public function storeMeeting(Request $request) 
    {
        
        $request->validate([
            "projectId" => "required|numeric",
            'meetingDate' => 'required|date|after:now',
        ]);

        
        $projectMeeting = DB::table('project_meetings')->insert([
            'project_id' => $request->projectId,
            'meetingDate' => $request->meetingDate,
            'status' => 0,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        $project = Project::findOrFail($request->projectId);

        $projectMembersIds = DB::table('project_user')
            ->where('project_id', $request->projectId)
            ->pluck('user_id');
        
        $users = User::whereIn('id', $projectMembersIds)->get();

        $action = [
            'type' => 'send_reminder',
            'meetingDate' => $request['meetingDate'], 
        ];
        foreach ($users as $user) {
            $this->removeOrAddUserToProjectMail($project, $user, $action);
        }

        return response()->json([
            'success' => true,
            'message' => __('Project Meeting Created Successfully'),
        ]);

    }

    public function updateMeeting(Request $request, $id)
    {
        $request->validate([
            'meetingDescription' => 'required|string',
        ]);

        $meeting = ProjectMeeting::findOrFail($id);

        if ($meeting) {
            $meeting->update([
                'description' => $request->meetingDescription,
                'status' => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('Project Meeting Updated Successfully'),
        ]);
    }
}
