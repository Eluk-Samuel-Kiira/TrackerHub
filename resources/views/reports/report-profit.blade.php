<x-app-layout>
    @section('title', __('Profit Analysis'))
    @section('content')
    
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Profit Analysis Report')}}</h1>
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
                    <li class="breadcrumb-item text-muted">{{__('Profit Analysis')}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div id="status"></div>
                <div class="card">
                    <div class="container mt-5">
                        <table class="table table-bordered" id="kt_table_project">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Currency</th>
                                    <th>Project Cost</th>
                                    <th>Project Budget</th>
                                    <th>Expected Profit (At Budget Cost)</th>
                                    <th>Expected Profit (At Budget Limit)</th>
                                    <th>Actual Profit (At Hand)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_profit = 0;
                                @endphp
                                @forelse($combinedData as $data)
                                    @php
                                        $project = $data['project'];
                                        $client_payments = $data['client_payments'];
                                        $totalApproved = $data['total_approved'];
                                        $requisitions = $data['requisitions'];
                                        $invoices = $data['invoices'];

                                        // Calculate overall cost
                                        $payments_received = $client_payments->sum('amount');

                                        // Additional Calculations
                                        $expectedProfit = $project->projectCost - $project->projectBudget;
                                        $expectedProfitAtLimit = $project->projectCost - $project->projectBudgetLimit;
                                        // actual profit is the amount the client has paid minus what we have spent already 
                                        $actualProfit = $payments_received - $totalApproved;

                                        // Ensure calculations account for negative values
                                        $profitMargin = $expectedProfit != 0 
                                            ? ($actualProfit / abs($expectedProfit)) * 100 
                                            : 0;
                                    @endphp

                                    <tr>
                                        <td>{{ $project->projectCode }}</td>
                                        <td>{{ $project->projectName }}</td>
                                        <td>{{ $project->currency->name ?? 'N\A' }}</td>
                                        <td>{{ $project->projectCost }}</td>
                                        <td>{{ $project->projectBudget }}</td>
                                        <td>{{ number_format($expectedProfit, 2) }}</td>
                                        <td>{{ number_format($expectedProfitAtLimit, 2)}}</td>
                                        <td>{{ number_format($actualProfit, 2) }}</td>
                                    </tr>
                                    @php
                                        $total_profit =  $total_profit + $actualProfit;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Requisitions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{__('Total Profit: ')}} {{ number_format($total_profit, 2) }}
                </h1>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#kt_table_project').DataTable({
                dom: 'Bfrtip', // Enables buttons and filtering options
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Download CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        text: 'Print Table',
                        className: 'btn btn-secondary'
                    }
                ],
                paging: true, // Enable pagination
                searching: true, // Enable search/filter
                ordering: true, // Enable sorting
                responsive: true, // Enable responsiveness
            });
        });
    </script>


    @endsection
</x-app-layout>