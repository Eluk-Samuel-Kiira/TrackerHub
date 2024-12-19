<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\removeOrAddUserMail; 

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'projectId' => 'required',
            'taskCode' => 'required|unique:tasks', 
            'task' => 'required|string',
            'taskDeadlineDate' => 'required|date',
            'projectMemberId' => 'required',
        ]);
        

        $task = Task::create([
            'taskCode' => $request->taskCode,
            'project_id' => $request->projectId,
            'user_id' => $request->projectMemberId,
            'description' => $request->task,
            'dueDate' => $request->taskDeadlineDate,
        ]);

        if ($task) {

            $project = Project::findOrFail($task->project_id);
            $user = User::find($task->user_id);

            $this->taskAssignmentMail($project, $task, $user);

            return response()->json([
                'success' => true,
                'message' => __('Task Created Successfully'),
            ]);

            // session()->flash('toast', [
            //     'type' => 'success',
            //     'message' => 'Task Added to project successfully.',
            // ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to add the task to the project.',
            ]);
        }

        return redirect(url('projects/'.$request->projectId.'#tasks'))->with('project', $request->projectId);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_id' => 'required|numeric',
            'completionDate' => 'required|date',
        ]);

        $task = Task::find($request->task_id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => __('Task not found'),
            ], 404);
        }

        $task->update([
            'completionDate' => $request->completionDate,
            'status' => 1,
        ]);

        // determine if project is completed or not
        // $totalTasks = Task::whereIn('project_id', $task->project_id)->count();
        // $completedTasks = $totalTasks->where('status', 1)->count();
        // $percentageCompleted = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        // \Log::info($percentageCompleted);
        // $project = Project::find($task->project_id);
        // if ($percentageCompleted == 100) {
        //     $project->completionStatus  = 1;
        //     $project->save();
        // }
        return response()->json([
            'success' => true,
            'message' => __('Task Paid Successfully'),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->delete()) {
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Task removed from the project successfully.',
            ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to remove the task from the project.',
            ]);
        }

        return redirect(url('projects/'.$task->project->id.'#tasks'))->with('project', $task->project->id);
    }


    private function taskAssignmentMail($project, $task, $user)
    {
        
        if (getMailOptions('mail_status') === 'enabled') {
            $companyName = getMailOptions('app_name');
            $subject = sprintf(
                'Task Assignment for the %s Project',
                $project->projectName
            );

            $emailMessage = sprintf(
                "Hello %s,\n\nYou have been assigned a new task: '%s'.\n".
                "Please ensure this task is completed by %s. We encourage you to give it your best effort and accomplish it before the deadline.\n\nThank you,\n%s",
                $user->name,
                $task->description,
                $task->dueDate,
                $companyName
            );

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


}
