<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectExpense;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Requistion;
use App\Models\ProjectInvoice;

class ProjectExpenseController extends Controller
{
    
    public function index(Request $request)
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


            return [
                'project' => $project,
                'total_approved' => $requisition ? $requisition->total_approved : 0,
            ];
        });

        return view('requistions.expense-index', [
            'combinedData' => $combinedData,
        ]);
    }


}
