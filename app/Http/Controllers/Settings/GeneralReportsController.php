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
    public function index(Request $request) 
    {

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

    public function expenseReport(Request $request) 
    {

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

    public function requisitionReport(Request $request) 
    {
        $requisitions = Requistion::with('requisitionProject')->latest()->get();
        
        return view('reports.report-requisitions', [
            'requisitions' => $requisitions,
        ]);
    }

    public function profitReport(Request $request) 
    {
        
        $approvedRequisitions = ProjectExpense::select('project_id', DB::raw('SUM(approved_amount) as total_approved'))
            ->whereIn('project_id', Project::pluck('id')) // Ensure project_id exists in Projects
            ->groupBy('project_id') // Group by project_id
            ->get();

        $projects = Project::whereIn('id', $approvedRequisitions->pluck('project_id'))->get();
        $project_requisitions = Requistion::whereIn('project_id', $approvedRequisitions->pluck('project_id'))->get();
        $client_payments = ProjectInvoice::whereIn('project_id', $approvedRequisitions->pluck('project_id'))
            ->where('isPaid', 1)
            ->whereNotNull('paidOn')
            ->get();

        // Combine the projects, approved requisitions, project requisitions, and client payments for ease of use
        $combinedData = $projects->map(function ($project) use ($approvedRequisitions, $project_requisitions, $client_payments) {
            $requisition = $approvedRequisitions->firstWhere('project_id', $project->id);

            // Filter project-specific requisitions
            $relatedRequisitions = $project_requisitions->where('project_id', $project->id)->where('status', 'approved')->where('isActive', 0);
            $paid_invoices = $client_payments->where('project_id', $project->id)->where('isPaid', 1)->where('isActive', 0);

            // Filter project-specific client payments
            $relatedClientPayments = $client_payments->where('project_id', $project->id);

            return [
                'project' => $project,
                'total_approved' => $requisition ? $requisition->total_approved : 0,
                'requisitions' => $relatedRequisitions,
                'invoices' => $paid_invoices,
                'client_payments' => $relatedClientPayments,
            ];
        });

        return view('reports.report-profit', [
            'combinedData' => $combinedData,
        ]);
    }
}
