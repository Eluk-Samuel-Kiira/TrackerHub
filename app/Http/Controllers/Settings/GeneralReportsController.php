<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectExpense;
use Illuminate\Support\Facades\DB;
use App\Models\Requistion;
use App\Models\ProjectInvoice;

class GeneralReportsController extends Controller
{
    public function index(Request $request) {

        $query = Project::with('tasks');

        $projects = $query->latest()->get()->map(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->whereNotNull('completionDate')->count();

            return [
                'id' => $project->id,
                'code' => $project->projectCode,
                'name' => $project->projectName,
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'progressPercentage' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0,
            ];
        });

        return view('reports.report-index', [
            'projects' => $projects,
        ]);
    }

    public function expenseReport(Request $request) {

        $approvedRequisitions = ProjectExpense::select('project_id', DB::raw('SUM(approved_amount) as total_approved'))
            ->whereIn('project_id', Project::pluck('id')) // Ensure project_id exists in Projects
            ->groupBy('project_id')
            ->get();

        $projects = Project::whereIn('id', $approvedRequisitions->pluck('project_id'))->get();

        $project_requisitions = Requistion::whereIn('project_id', $approvedRequisitions->pluck('project_id'))
            ->where('status', 'approved')
            ->where('isActive', 0)
            ->get();

            
        // Combine the projects, approved requisitions, project requisitions, and client payments
        $combinedData = $projects->map(function ($project) use ($approvedRequisitions, $project_requisitions) {
            $requisition = $approvedRequisitions->firstWhere('project_id', $project->id);

            // Approved and active requisitions for this project
            $relatedRequisitions = $project_requisitions->where('project_id', $project->id);
            $totalSpentOnRequisitions = $relatedRequisitions->sum('approved_amount');


            return [
                'project' => $project,
                'projectBudget' => $project->budget ?? 0, // Assuming `budget` exists in Project model
                'total_approved' => $requisition ? $requisition->total_approved : 0,
                
            ];
        });
        return view('reports.report-expenses', [
           'combinedData' => $combinedData,
        ]);

    }

}
