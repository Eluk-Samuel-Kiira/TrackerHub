<x-app-layout>
    @section('title', __('Dashboard'))
    @section('content')
    
    
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('General Dashboard')}}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        @php
                            $previousUrl = url()->previous();
                            $previousRouteName = optional(app('router')->getRoutes()->match(request()->create($previousUrl)))->getName();
                            $formattedRouteName = $previousRouteName 
                                ? Str::of($previousRouteName)->replace('.', ' ')->title() 
                                : __('Back');
                        @endphp
                        <a href="{{ $previousUrl }}" class="text-muted text-hover-primary">
                            {{ $formattedRouteName }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{__('General Reports')}}</li>
                </ul>
            </div>

        </div>
    </div>

    
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div id="status"></div>

                <div class="row gx-5 gx-xl-10">
                        <div class="col-xxl-6 mb-5 mb-xl-10">
                            <div class="card card-flush h-xl-100">
                                <div class="card-header pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-900">Performance Overview</span>
                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">Users from all channels</span>
                                    </h3>
                                </div>
                                <div class="container">
                                    <canvas id="performanceChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $dashboardData['projectIsActive'] ?? 0}} </span>
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                                    </div>
                                </div>
                                <div class="card-body d-flex align-items-end pt-0">
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>{{ $dashboardData['projectIsPending'] ?? 0}} Pending</span>
                                            <span>{{ $dashboardData['percentagePending'] ?? 0 }}%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $dashboardData['percentagePending']  ?? 0}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $dashboardData['users']->count() }}</span>
                                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Professionals</span>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-end pe-0">
                                    <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Company Heroes</span>
                                    <div class="symbol-group symbol-hover flex-nowrap">
                                        @foreach($dashboardData['users'] as $user)
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $user->first_name .' '. $user->last_name }}">
                                                @if(!empty($user->profile_image) && file_exists(public_path('storage/' . $user->profile_image)))
                                                    <img alt="P" src="{{ asset('storage/' . $user->profile_image) }}" />
                                                @else
                                                    <span class="symbol-label bg-secondary text-inverse-secondary fw-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($dashboardData['users']->count() > 6)
                                            <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                                <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+{{ $dashboardData['users']->count() - 6 }}</span>
                                            </a>
                                        @endif
                                        @include('dashboard.user-modal')
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">/=</span>
                                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">
                                                {{ $monthlyData['earningsWithIncrease'][$monthlyData['latestMonth']]['earnings'] ?? 0}}
                                            </span>
                                            @php
                                                $percentageIncrease = $monthlyData['earningsWithIncrease'][$monthlyData['latestMonth']]['percentageIncrease'] ?? 0;
                                                $isPositive = $percentageIncrease >= 0;
                                            @endphp

                                            <span class="badge {{ $isPositive ? 'badge-light-success' : 'badge-light-danger' }} fs-base">
                                                <i class="ki-duotone {{ $isPositive ? 'ki-arrow-up' : 'ki-arrow-down' }} fs-5 {{ $isPositive ? 'text-success' : 'text-danger' }} ms-n1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                {{ $percentageIncrease }}%
                                            </span>
                                        </div>
                                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Projects Earnings in 
                                            {{ \Carbon\Carbon::parse($monthlyData['latestMonth'])->format('F') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <div class="d-flex flex-center me-5 pt-2">
                                        <div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                                    </div>
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <div class="d-flex fw-semibold align-items-center">
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <div class="text-gray-500 flex-grow-1 me-4">{{ $monthlyData['topProjects'][0]['projectCode'] ?? 'N/A' }}</div>
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ number_format($monthlyData['topProjects'][0]['earnings'] ?? 0, 2) }} /=</div>
                                        </div>
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <div class="text-gray-500 flex-grow-1 me-4">{{ $monthlyData['topProjects'][1]['projectCode'] ?? 'N/A' }}</div>
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ number_format($monthlyData['topProjects'][1]['earnings'] ?? 0, 2) }} /=</div>
                                        </div>
                                        <div class="d-flex fw-semibold align-items-center">
                                            <div class="bullet w-8px h-3px rounded-2 me-3" style="background-color: #E4E6EF"></div>
                                            <div class="text-gray-500 flex-grow-1 me-4">Others</div>
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ number_format($monthlyData['otherEarnings'] ?? 0, 2) }} /=</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card card-flush h-lg-50">
                                <div class="card-header pt-5">
                                    <h3 class="card-title text-gray-800 fw-bold">Online & Past Users</h3>
                                    <div class="card-toolbar">
                                        <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                            <i class="ki-duotone ki-dots-square fs-1 text-gray-500 me-n1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                            
                                            <div class="separator mb-3 opacity-75"></div>
                                            <div class="menu-item px-3">
                                                <a href="/dashboard" class="menu-link px-3">Refresh</a>
                                            </div>
                                            <!-- <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body pt-5">
                                    <div class="d-flex flex-column">
                                        @foreach ($recentActivities as $activity)
                                            <div class="d-flex flex-stack mb-4">
                                                <a href="#" class="text-primary fw-semibold fs-6 me-2">{{ $activity['user'] }}</a>
                                                <span class="text-gray-600 fs-7 me-2">{{ $activity['time'] }}</span>
                                                <button type="button" class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#sessionModal{{ $loop->index }}">
                                                    <i class="ki-duotone ki-exit-right-corner fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </div>
                                            <div class="separator separator-dashed my-3"></div>
                                        @endforeach
                                        @include('dashboard.session-details')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/get-project-progress-data') // Adjust the endpoint URL as needed
                .then(response => response.json())
                .then(data => {
                    // Extract labels and data for the chart
                    const labels = data.map(project => project.projectName);
                    const percentages = data.map(project => project.percentageCompletion);

                    

                    // Create the chart
                    const ctx = document.getElementById('performanceChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar', // Change to 'bar' for better representation
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Percentage Completion (%)',
                                    data: percentages,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue
                                    borderColor: 'rgba(54, 162, 235, 1)', // Blue
                                    borderWidth: 1,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100, 
                                },
                            },
                        },
                    });
                })
                .catch(error => console.error('Error fetching project progress data:', error));
        });
    </script>

    @endsection
</x-app-layout>