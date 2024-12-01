<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $projects = Project::all();
        $users = User::where('status', 'active')->get();
        $totalProjects = Project::count(); 
        $projectIsActive = Project::where('isActive', 1)->count(); 
        $projectIsPending = Project::where('completionStatus', 0)->count(); 

        // Calculate the percentage of pending projects
        $percentagePending = $totalProjects > 0 
            ? round(($projectIsPending / $totalProjects) * 100, 2) 
            : 0;

        // Combine all values into a single array
        $dashboardData = [
            'users' => $users,
            'totalProjects' => $totalProjects,
            'projectIsActive' => $projectIsActive,
            'projectIsPending' => $projectIsPending,
            'percentagePending' => $percentagePending,
        ];


        // Step 1: Group projects by their month of `projectDeadlineDate`
        $groupedProjects = $projects->groupBy(function ($project) {
            return \Carbon\Carbon::parse($project->created_at)->format('Y-m');
        });


        $monthlyEarnings = [];
        foreach ($groupedProjects as $month => $monthProjects) {
            $totalEarnings = $monthProjects->sum(function ($project) {
                return $project->projectCost - $project->projectBudget;
            });

            $monthlyEarnings[$month] = $totalEarnings;
        }

        // dd($monthlyEarnings);

        // Step 2: Calculate percentage increase
        $earningsWithIncrease = [];
        $previousEarnings = 0;

        foreach ($monthlyEarnings as $month => $earnings) {
            // Calculate percentage increase, considering both positive and negative values
            if ($previousEarnings != 0) {
                $percentageIncrease = round((($earnings - $previousEarnings) / abs($previousEarnings)) * 100, 2);
            } else {
                $percentageIncrease = 0; // No comparison for the first entry
            }

            $earningsWithIncrease[$month] = [
                'earnings' => $earnings,
                'percentageIncrease' => $percentageIncrease,
            ];

            // Update previousEarnings
            $previousEarnings = $earnings;
        }


        // Step 3: Pluck the top 2 and sum others
        $latestMonth = array_key_last($earningsWithIncrease);
        $currentMonthProjects = $groupedProjects[$latestMonth] ?? collect();

        $topProjects = $currentMonthProjects->sortByDesc(function ($project) {
            return $project->projectCost - $project->projectBudget;
        })->take(2)->values(); // Reset the keys to sequential indices.
        
        $topProjectsData = $topProjects->map(function ($project) {
            return [
                'projectCode' => $project->projectCode,
                'earnings' => $project->projectCost - $project->projectBudget,
            ];
        });
        
        // // Debugging
        // die($topProjectsData->toJson());
        

        $otherProjectsEarnings = $currentMonthProjects
            ->whereNotIn('id', $topProjects->pluck('id'))
            ->sum(function ($project) {
                return $project->projectCost - $project->projectBudget;
            });

        $monthlyData = [
            'earningsWithIncrease' => $earningsWithIncrease,
            'latestMonth' => $latestMonth,
            'topProjects' => $topProjectsData,
            'otherEarnings' => $otherProjectsEarnings,
        ];


        // sessions
        $sessions = DB::table('sessions')->get();
        $recentActivities = [];

        foreach ($sessions as $session) {
            // Ensure the session contains a valid 'user_id'
            if (!empty($session->user_id)) {
                // Retrieve the user by ID
                $user = User::find($session->user_id);

                if ($user) {
                    // Calculate the time difference between last activity and current time
                    $lastActivity = Carbon::createFromTimestamp($session->last_activity);
                    $diffForHumans = $lastActivity->diffForHumans();

                    // Add session details, including user_agent and ip_address
                    $recentActivities[] = [
                        'user' => $user->name,
                        'time' => $diffForHumans,
                        'activity' => 'Online', // You can customize this to reflect specific activities
                        'user_agent' => $session->user_agent ?? 'N/A', // Add user agent from session
                        'ip_address' => $session->ip_address ?? 'N/A', // Add IP address from session
                    ];
                }
            }
        }

        return view('dashboard.dashboard-index', compact('dashboardData', 'monthlyData', 'recentActivities'));

    }


}
