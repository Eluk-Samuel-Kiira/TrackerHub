<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

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
            'taskCode' => 'required|unique:tasks,taskCode', // Use taskCode as per the input name
            'task' => 'required|string',
            'taskDeadlineDate' => 'required|date',
            'projectMemberId' => 'required', // This matches the name of the select input
        ]);

        $task = Task::create([
            'taskCode' => $request->taskCode,
            'project_id' => $request->projectId,
            'user_id' => $request->projectMemberId,
            'description' => $request->task,
            'dueDate' => $request->taskDeadlineDate,
        ]);

        if ($task) {
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Task Added to project successfully.',
            ]);
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
        //
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
}
